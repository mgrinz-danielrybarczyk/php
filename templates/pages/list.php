<div>
    <div class="message">
        <?php
            if(!empty($params['before']))
            {
                switch($params['before'])
                {
                    case 'created':
                        echo 'Utworzono nową Notatkę!';
                        break;
                }
            }
        ?>
    </div>
    <h2>Lista notatek</h2>
    <b><?php echo $params['resultList'] ?? "" ?></b>
</div>