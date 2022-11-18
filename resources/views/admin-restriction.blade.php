<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</head>

<body class="antialiased container" style="margin-top: 100px">
    <br />
    <br />
    <br />
    <div class="row mt-5">
        <div class="col-md-12 text-center bg-dark">
            <div class="card shadow-sm bg-light">
                <img
                    src="data:image/png;base64,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" />
                <br />
                <p class="text-danger mt-2">You dont have access to this page</p>


            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
</body>

</html>
