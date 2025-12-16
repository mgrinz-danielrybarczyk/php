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
                    }
                }
            ?>
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
                        </td>
                        
                    </tr>
                    <?php endforeach; ?>     
            </table>
        </div>
    </section>
</div>