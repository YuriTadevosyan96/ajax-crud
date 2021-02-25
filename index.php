<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/styles/index.css">
</head>
<body>
    <div class="container-fluid border border-light p-2">
        <div class="row">
            <div class="col">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Эл. почта</th>
                            <th scope="col">Профессия</th>
                            <th scope="col">Возраст</th>
                            <th scope="col">Действия</th>
                        </tr>
                    </thead>
                    <tbody id="mainContent">
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary" id="addItem" data-bs-toggle="modal" data-bs-target="#addEditUserForm">
                    Добавить
                </button>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addEditUserForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addEditUserFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="submitForm" name="submitForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" required autocomplete="off" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Эл. почта</label>
                        <input type="email" class="form-control" id="email" name="email" required autocomplete="off" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label for="profession" class="form-label">Профессия</label>
                        <input type="text" class="form-control" id="profession" name="profession" autocomplete="off" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Возраст</label>
                        <input type="number" class="form-control" id="age" name="age" min="1" max="150" autocomplete="off">
                    </div>
                    <input type="hidden" name="create_or_edit" id="create_or_edit">
                    <input type="hidden" name="edit_item_id" id="edit_item_id">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Сохранять</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="./assets/scripts/index.js"></script>
</body>
</html>