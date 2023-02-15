<?php

namespace App\Http\Controllers;

use App\DataTables\SellerProductDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSellerProductRequest;
use App\Http\Requests\UpdateSellerProductRequest;
use App\Repositories\SellerProductRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SellerProductController extends AppBaseController
{
    /** @var SellerProductRepository $sellerProductRepository*/
    private $sellerProductRepository;

    public function __construct(SellerProductRepository $sellerProductRepo)
    {
        $this->sellerProductRepository = $sellerProductRepo;
    }

    /**
     * Display a listing of the SellerProduct.
     *
     * @param SellerProductDataTable $sellerProductDataTable
     *
     * @return Response
     */
    public function index(SellerProductDataTable $sellerProductDataTable)
    {
        return $sellerProductDataTable->render('seller_products.index');
    }

    /**
     * Show the form for creating a new SellerProduct.
     *
     * @return Response
     */
    public function create()
    {
        return view('seller_products.create');
    }

    /**
     * Store a newly created SellerProduct in storage.
     *
     * @param CreateSellerProductRequest $request
     *
     * @return Response
     */
    public function store(CreateSellerProductRequest $request)
    {
        $input = $request->all();

        $sellerProduct = $this->sellerProductRepository->create($input);

        Flash::success('Seller Product saved successfully.');

        return redirect(route('sellerProducts.index'));
    }

    /**
     * Display the specified SellerProduct.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            Flash::error('Seller Product not found');

            return redirect(route('sellerProducts.index'));
        }

        return view('seller_products.show')->with('sellerProduct', $sellerProduct);
    }

    /**
     * Show the form for editing the specified SellerProduct.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            Flash::error('Seller Product not found');

            return redirect(route('sellerProducts.index'));
        }

        return view('seller_products.edit')->with('sellerProduct', $sellerProduct);
    }

    /**
     * Update the specified SellerProduct in storage.
     *
     * @param int $id
     * @param UpdateSellerProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSellerProductRequest $request)
    {
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            Flash::error('Seller Product not found');

            return redirect(route('sellerProducts.index'));
        }

        $sellerProduct = $this->sellerProductRepository->update($request->all(), $id);

        Flash::success('Seller Product updated successfully.');

        return redirect(route('sellerProducts.index'));
    }

    /**
     * Remove the specified SellerProduct from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sellerProduct = $this->sellerProductRepository->find($id);

        if (empty($sellerProduct)) {
            Flash::error('Seller Product not found');

            return redirect(route('sellerProducts.index'));
        }

        $this->sellerProductRepository->delete($id);

        Flash::success('Seller Product deleted successfully.');

        return redirect(route('sellerProducts.index'));
    }
}
