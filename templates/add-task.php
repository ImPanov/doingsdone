<div class="content">
        <section class="content__side">
                <h2 class="content__side-heading">Проекты</h2>

                <nav class="main-navigation">
                    <ul class="main-navigation__list">
                        <?php foreach($projects as $project): ?>
                        <li class="main-navigation__list-item">
                            <a class="main-navigation__list-item-link" href="index.php?project_id=<?=$project["id"]?>"><?=$project["title"]?></a>
                            <span class="main-navigation__list-item-count"><?=$project["project_count"]?></span>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </nav>
                  <a class="button button--transparent button--plus content__side-button" href="form-project.html">Добавить проект</a>
              </section>

      <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form"  action="add-task.php" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="name" value="<?=$task["name"] ?? null?>" placeholder="Введите название">
          </div>
          <p class="form__message"><?=$errors["name"] ?? ""?></p>
          <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select" name="project" id="project">
                <?php foreach($projects as $project): ?>
              <option value="<?=$project["id"]?>"><?=$project["title"]?></option>
                <?php endforeach; ?>
            </select>
          </div>
          <p class="form__message"><?=$errors["project"] ?? ""?></p>
          <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="text" name="date" id="date" value="<?=$task["date"] ?? null?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
          </div>
          <p class="form__message"><?=$errors["date"] ?? ""?></p>
          <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="file-lot" id="file" value="">
              <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
              </label>
            </div>
            <p class="form__message"><?=$errors["file"] ?? ""?></p>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
      </main>
    </div>
  </div>
</div>
