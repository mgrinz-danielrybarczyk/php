<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if($note) : ?>
        <ul>
            <li>Tytuł: <?php echo $note['title'] ?></li>
            <li></br> <?php echo htmlentities($note['description']) ?></li>
            <li></br>Utworzono: <?php echo htmlentities($note['created']) ?></li>   
        </ul>
        <?php else : ?>
            <div>Brak notatki do wyświetlenia</div>
    <?php endif; ?>

    </br><a href="/"><button>Powrót</button></a>

</div>