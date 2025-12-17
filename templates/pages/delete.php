<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if($note) : ?>
        <ul>
            <li>Tytuł: <?php echo $note['title'] ?></li>
            <li></br> <?php echo $note['description'] ?></li>
            <li></br>Utworzono: <?php echo $note['created'] ?></li>   
        </ul>
        <?php else : ?>
            <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>
    
    <form class="note-form" method="POST" action="/?action=delete"> 
        <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
        <input type="submit" value="Usuń"/>
    </form>
    <a href="/"><button>Powrót</button></a>

    

</div>