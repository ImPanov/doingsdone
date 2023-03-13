<main class="content__main">
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

        <h2 class="content__main-heading">Добавление проекта</h2>

        <form class="form"  action="add-project.php" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="project_name" value="<?=$project ?? ""?>" placeholder="Введите название проекта">
          </div>
          <p class="form__message"><?=$error ?? ""?></p>
          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
      </main>
    </div>
  </div>
</div>
