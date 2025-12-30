<div>
    <section>

        <?php if(!empty($params['error'])) : ?>
            <div class="message">
                <?php
                    switch($params['error']) 
                    {
                        case 'noteNotFound':
                            echo "Notatka nie została znaleziona";
                            break;
                        case 'missingNoteId':
                            echo "Niepoprawny identyfikator notatki";
                            break;
                    }
                ?>
            </div>
        <?php endif; ?>
            
        <div class="message">
            <?php
                if(!empty($params['before']))
                {
                    switch($params['before'])
                    {
                        case 'created':
                            echo 'Utworzono nową Notatkę!';
                            break;
                        case 'edited':
                            echo 'Zaktualizowano notatkę!';
                            break;
                        case 'deleted':
                            echo 'Usunięto notatkę!';
                            break;
                    }
                }
            ?>
        </div>
        <?php 
        $sort = $params['sort'] ?? [];
        $by = $sort['by'] ?? 'title';
        $order = $sort['order'] ?? 'desc';

        $page = $params['page'] ?? [];
        $size = $page['size'] ?? 10;
        $currentPage = $page['number'] ?? 1;
        $pages = $page['pages'] ?? 1;

        $phrase = $params['phrase'] ?? null;

        ?>
        <div>
            <form class="settings-form" action="/" method="GET">
                <div>
                    <label>Wyszukaj notatkę po tytule: <input type="text" name="phrase" value="<?php echo $phrase ?>"/></label>
                </div>
                <div>
                    <div>Sortuj po:</div>
                        <label>Tytule: <input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked' : '' ?>/></label>
                        <label>Dacie: <input name="sortby" type="radio" value="created" <?php echo $by === 'created' ? 'checked' : '' ?>/></label> 
                </div>
                <div>   
                    <div>Kierunek sortowania:</div>
                    <label>Rosnąco: <input name="sortorder" type="radio" value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?>/></label>
                    <label>Malejąco: <input name="sortorder" type="radio" value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?>/></label> 
                </div>
                <div>
                    <div>Ilość notatek:</div>
                    <label>1 <input name="pagesize" type="radio" value="1" <?php echo $size === 1 ? 'checked' : '' ?>/></label>
                    <label>5 <input name="pagesize" type="radio" value="5" <?php echo $size === 5 ? 'checked' : '' ?>/></label>
                    <label>10 <input name="pagesize" type="radio" value="10" <?php echo $size === 10 ? 'checked' : '' ?>/></label>
                    <label>25 <input name="pagesize" type="radio" value="25" <?php echo $size === 25 ? 'checked' : '' ?>/></label>
                </div>
                <input type="submit" value="Wyślij">
            </form>
        </div>
        <div class="tbl-header">
            <table callpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tytuł</th>
                        <th>Data</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <?php foreach($params['notes'] ?? [] as $note) : ?>
                    <tr>
                        
                        <td><?php echo $note['id'] ?></td>
                        <td><?php echo $note['title'] ?></td>
                        <td><?php echo $note['created'] ?></td>
                        <td>
                            <a href="/?action=show&id=<?php echo (int) $note['id']?>"><button>Szczegóły</button></a>
                            <a href="/?action=delete&id=<?php echo (int) $note['id']?>"><button>Usuń</button></a>
                        </td>
                        
                    </tr>
                    <?php endforeach; ?>     
            </table>
        </div>

        <?php
            $paginationUrl = "&phrase=$phrase&pagesize=$size&sortby=$by&sortorder=$order";
        ?>

        <ul class="pagination">
            <?php if($currentPage !== 1) : ?>
                <li>
                    <a href="/?page=<?php echo $currentPage-1 . $paginationUrl ?>">
                        <button><<</button>
                    </a>
                </li>
            <?php endif; ?>

            <?php for($i = 1; $i <= $pages; $i++) : ?>
                <li>
                    <a href="/?page=<?php echo $i . $paginationUrl ?>">
                        <button><?php echo $i; ?></button>
                    </a>
                </li>
            <?php endfor; ?>
                <?php if($currentPage < $pages) : ?>
                    <li>
                        <a href="/?page=<?php echo $currentPage+1 . $paginationUrl ?>">
                            <button>>></button>
                        </a>
                    </li>
                <?php endif; ?>

        </ul>

    </section>
</div>