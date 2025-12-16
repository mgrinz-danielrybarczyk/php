<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if($note) : ?>
        <ul>
            <li>Tytuł: <?php echo $note['title'] ?></li>
            <li></br> <?php echo $note['description'] ?></li>
            <li></br>Utworzono: <?php echo $note['created'] ?></li>   
        </ul>
        </br><a href="?action=edit&id=<?php echo $note['id'] ?>"><button>Edytuj</button></a>
        <?php else : ?>
            <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>

    <a href="/"><button>Powrót</button></a>

</div>