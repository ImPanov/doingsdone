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

                <a class="button button--transparent button--plus content__side-button"
                   href="add-project.php" target="project_add">Добавить проект</a>
            </section>

            <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post" autocomplete="off">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="index.php" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                        <a href="index.php?tr=today" class="tasks-switch__item">Повестка дня</a>
                        <a href="index.php?tr=nextday" class="tasks-switch__item">Завтра</a>
                        <a href="index.php?tr=defeat" class="tasks-switch__item">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        
                        <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
                        <input class="checkbox__input visually-hidden show_completed"<?=$show_complete_tasks==1 ? ' checked' : ''?> type="checkbox">
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
                    <?php foreach($tasks as $task): ?>
                        <?php if(!$show_complete_tasks){
                            if($task["status"]){
                            continue;
                            }}?>
                    <tr class="tasks__item task">
                        <td class="task__select">
                            <label class="checkbox task__checkbox">
                                <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" <?=$task["status"]==1 ? ' checked' : ''?> value="<?=$task["id"]?>">
                                <span class="checkbox__text"><?=$task["title"]?></span>
                            </label>
                        </td>

                        <td class="task__file">
                            <a class="download-link" href="<?= $task["file"]?>" download><?=substr($task["file"],8)?></a>
                        </td>

                        <td class="task__date"><?= $task["deadline"] ? date_format(date_create($task["deadline"]),"d.m.Y") : null ?></td>
                    <?php endforeach;?>
                    </tr>
                    <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
                </table>
            </main>
        </div>
    </div>
</div>