<div class="content">
        <section class="content__side">
          <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

          <a class="button button--transparent content__side-button" href="sign-in.php">Войти</a>
        </section>

        <main class="content__main">
          <h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" action="sign-up.php" method="post" autocomplete="off">
            <div class="form__row">
              <label class="form__label" for="email">E-mail <sup>*</sup></label>

              <input class="form__input <?=isset($errors['fail']) ? 'form__input--error' : ''?>form__input--error" type="text" name="email" id="email" value="<?=$user["email"]??""?>" placeholder="Введите e-mail">

              <p class="form__message"><?=$errors["email"] ?? ""?></p>
            </div>

            <div class="form__row">
              <label class="form__label" for="password">Пароль <sup>*</sup></label>

              <input class="form__input" type="password" name="password" id="password" value="<?=$user["password"]??""?>" placeholder="Введите пароль">
            </div>

            <div class="form__row">
              <label class="form__label" for="name">Имя <sup>*</sup></label>

              <input class="form__input" type="text" name="name" id="name" value="<?=$user["name"]??""?>" placeholder="Введите имя">
            </div>

            <div class="form__row form__row--controls">
              <p class="error-message"><?=isset($errors['fail']) ? 'Пожалуйста, исправьте ошибки в форме.' : ''?></p>

              <input class="button" type="submit" name="" value="Зарегистрироваться">
            </div>
          </form>
        </main>
      </div>
    </div>
  </div>