<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <?= $this->include('partials/navbar') ?>
    <div class="row">
        <div class="col">
        </div>
        <div class="col-sm">
            <h1>Post list</h1>

            <div class="row">
                <div class="col cards">
                    <?php if (count($posts) > 0) : ?>
                        <ul class="list-group">
                            <?php foreach ($posts as $post) : ?>
                                <li class="list-group-item"><a href="<?= url_to('post', $post['id']) ?>"><?= $post['title'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <?= $this->include('partials/pager_post') ?>
                    <?php else : ?>
                    No post yet
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col">
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>