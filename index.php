<?php
$errors = null;
$success = false;
require __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Message.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'GestBook.php';

$gestbook = new GestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' .  DIRECTORY_SEPARATOR . 'message');
if(isset($_POST['username']) && isset($_POST['message'])){

    $message = new Message($_POST['username'], $_POST['message']);
    if ($message->isValid()) {
        $gestbook->addMessage($message); 
        $success = true;
        $_POST = [];
    }else{
        $errors = $message->getErrors();
    }
}
$messages = $gestbook->getMessage();

$titre = 'FORUM';
require __DIR__ . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'header.php';
?>

<div class="container pt-5">
    <?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        Formulaire incorrect
    </div>
    <?php endif ?>

    <?php if($success): ?>
    <div class="alert alert-success">
        Merci pour votre message
    </div>
    <?php endif ?>

    <h1>Mon FORUM</h1>
    <form action="" method="post">
        <div class="form-group">
            <input value="<?= htmlentities($_POST['username'] ?? '' )?>" type="text" name="username"
                placeholder="Entrez votre nom d'utilisateur"
                class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
            <?php if(isset($errors['username'])): ?>
            <div class="invalid-feedback">
                <?= $errors['username'] ?>
            </div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Entrez votre message"
                class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['message'] ?? '')?></textarea>
            <?php if(isset($errors['message'])): ?>
            <div class="invalid-feedback">
                <?= $errors['message'] ?>
            </div>
            <?php endif ?>
        </div>
        <button type="submit" class="btn btn-warning">Envoyer</button>
    </form>
    <?php if (!empty($messages)):  ?>
    <h1 class="mt-5">Vos Messages -_- </h1>
    <?php foreach($messages as $message): ?>
    <?= $message->toHTML() ?>
    <?php  endforeach ?>
    <?php endif ?>
</div>

<?php require __DIR__ . DIRECTORY_SEPARATOR . 'elements' . DIRECTORY_SEPARATOR . 'footer.php'; ?>