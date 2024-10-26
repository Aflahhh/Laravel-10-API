<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="bg-light">
    <main class="container">
        <!-- START FORM -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <form action='' method='post'>
                @csrf
                @method('PUT')
                <div class="mb-3 row">
                    <label for="title" class="col-sm-2 col-form-label">Book Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='title' id="title"
                            value="{{ isset($data['title']) ? $data['title'] : old('title') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="author" class="col-sm-2 col-form-label">Author</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='author' id="author"
                            value="{{ isset($data['author']) ? $data['author'] : old('author') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="date_published" class="col-sm-2 col-form-label">Publish Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control w-50" name='publish_date' id="date_published"
                            value="{{ isset($data['publish_date']) ? $data['publish_date'] : old('publish_date') }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>


    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

</body>

</html>
