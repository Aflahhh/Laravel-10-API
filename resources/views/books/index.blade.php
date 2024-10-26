<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="bg-light">
    <main class="container">
        <!-- START FORM -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('create'))
                <div class="alert alert-success">
                    {{ session('create') }}
                </div>
            @elseif (session('delete'))
                <div class="alert alert-success">
                    {{ session('delete') }}
                </div>
            @endif

            <form action='' method='post'>

                @csrf
                @method('post')
                @if (Route::current()->uri == 'book/{book_id}')
                    @method('PUT') <!-- Gunakan PUT jika book_id ada -->
                @endif

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
        <!-- AKHIR FORM -->
        @if (Route::current()->uri == 'book')
            <!-- START DATA -->
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-4">Title</th>
                            <th class="col-md-3">Author</th>
                            <th class="col-md-2">Publish Date</th>
                            <th class="col-md-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $data['from']; ?>
                        @foreach ($data['data'] as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item['title'] }}</td>
                                <td>{{ $item['author'] }}</td>
                                <td>{{ $item['publish_date'] }}</td>
                                <td>

                                    <a href="{{ url('book/edit/' . $item['book_id']) }}" class="btn btn-info">edit</a>
                                    <form action="{{ url('book/' . $item['book_id']) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-success btn-floating"
                                            data-mdb-ripple-init><i class="fa-solid fa-edit"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
            <!-- AKHIR DATA -->
        @endif
        @if ($data['links'])
            <nav aria-label="...">
                <ul class="pagination">
                    @foreach ($data['links'] as $item)
                        <li
                            class="page-item {{ $item['active'] ? 'active' : '' }} {{ $item['url'] == false ? 'disabled' : '' }} {{ $item['url2'] == false ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $item['url2'] }}">{!! $item['label'] !!}</a>
                        </li>
                    @endforeach
                </ul>

            </nav>
        @endif
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

</body>

</html>
