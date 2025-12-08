<div>
    <section>
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
        
        <div class="tbl-header">
            <table callpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tytuł</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">

            </table>
        </div>
    </section>
</div>