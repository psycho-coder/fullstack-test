<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="/css/open-iconic-bootstrap.css" rel="stylesheet">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <?= $this->include('partials/navbar') ?>
    <div class="row">
        <div class="col">
            <h1><?= $post['title'] ?></h1>
            
            <div>
                <?= $post['content'] ?>
            </div>
            
            <hr>

            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $sort ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="#" data-action="field" data-order="Id">Id</a>
                        <a class="dropdown-item" href="#" data-action="field" data-order="Date">Date</a>
                    </div>
                </div>
                
                <button type="button" class="btn btn-secondary" data-action="order" data-order="<?= $order ?>"><span class="oi oi-arrow-<?= $order === 'asc' ? 'top' : 'bottom' ?>" title="icon name" aria-hidden="true"></span></button>
            </div>

            <hr>

            <div class="row">
                <div class="col cards">
                    <?php if (count($comments) > 0) : ?>
                    <?php foreach ($comments as $comment) : ?>
                        <div class="card" style="margin-bottom: 10px;" data-comment-id="<?= $comment['id'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $comment['name'] ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= $comment['date'] ?></h6>
                                <p class="card-text"><?= $comment['text'] ?></p>
                                <form action="<?= url_to('remove_comment', $comment['id']) ?>" method="POST">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                    <button class="btn btn-sm btn-danger" data-action="remove-comment">Remove</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?= $this->include('partials/pager_comment') ?>
                    <?php else : ?>
                    No comments yet
                    <?php endif; ?>
                </div>
            </div>
            
            <hr>
            
            <div>
                <div class="alert" data-alert role="alert" style="display: none;">
                </div>
            </div>
            
            <form action="<?= url_to('add_comment') ?>" method="POST" data-form="comment_form">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                
                <fieldset>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="email">@</span>
                        </div>
                        <input id="email-form" type="email" name="name" required class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email">
                    </div>

                    <label for="basic-url">Text</label>
                    <div class="input-group mb-3">
                        <textarea id="text-form" class="form-control" name="text" aria-label="Comment"></textarea>
                    </div>
                    
                    <div class="input-group mb-3">
                        <input id="date-form" type="date" name="date" required class="form-control" placeholder="Date" aria-label="Date" aria-describedby="date">
                    </div>
                    
                    <button class="btn btn-primary" data-action="send-comment" type="submit">Send</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<div data-template="comment" class="card" style="margin-bottom: 10px; display: none;">
    <div class="card-body">
        <h5 class="card-title"></h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <p class="card-text"></p>
        <input type="hidden" name="<?= csrf_token() ?>" value="">
        <form action="" method="POST"><button class="btn btn-sm btn-danger" data-action="remove-comment">Remove</button></form>
    </div>
</div>

<script>
    let ordering = {
        sort: '<?= $sort ?>',
        order: '<?= $order ?>'
    };
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="/js/comments.js"></script>
</body>
</html>