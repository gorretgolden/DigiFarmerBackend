<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateContactAPIRequest;
use App\Http\Requests\API\UpdateContactAPIRequest;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Carbon;
use App\Mail\ContactMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Class ContactController
 * @package App\Http\Controllers\API
 */

class ContactAPIController extends AppBaseController
{
    /** @var  ContactRepository */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepo)
    {
        $this->contactRepository = $contactRepo;
    }

    /**
     * Display a listing of the Contact.
     * GET|HEAD /contacts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $contacts = $this->contactRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($contacts->toArray(), 'Contacts retrieved successfully');
    }

    /**
     * Store a newly created Contact in storage.
     * POST /contacts
     *
     * @param CreateContactAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateContactAPIRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $user = User::find(auth()->user()->id);

        $contact = $this->contactRepository->create($input);

        $data = [
                'username' => $contact->user->username,
                'email' => $contact->user->email,
                'subject' => $contact->subject,
                'message' => $contact->message,
                'created_at' => $contact->created_at,
                'updated_at' => $contact->updated_at,

        ];
        Mail::to($user->email)->send(new ContactMail($data));
        return $this->sendResponse($data, 'Contact saved successfully');
    }

    /**
     * Display the specified Contact.
     * GET|HEAD /contacts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        return $this->sendResponse($contact->toArray(), 'Contact retrieved successfully');
    }

    /**
     * Update the specified Contact in storage.
     * PUT/PATCH /contacts/{id}
     *
     * @param int $id
     * @param UpdateContactAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContactAPIRequest $request)
    {
        $input = $request->all();

        /** @var Contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        $contact = $this->contactRepository->update($input, $id);

        return $this->sendResponse($contact->toArray(), 'Contact updated successfully');
    }

    /**
     * Remove the specified Contact from storage.
     * DELETE /contacts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        $contact->delete();

        return $this->sendSuccess('Contact deleted successfully');
    }
}
