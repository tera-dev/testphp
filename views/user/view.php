<?php if (isset($userData)): ?>
    <span>Пользователь с таким e-mail уже зарегистрирован! Данные:</span> <br/><br/>
    <span>Имя: <?=$userData['user_name']?></span> <br/><br/>
    <span>Email: <?=$userData['user_email']?></span> <br/><br/>
    <span>Адрес: <?=$userData['ter_address']?></span> <br/><br/>
<?php endif; ?>


<a href="./index.php?r=user/index"><input type="button" value="Назад"></a>