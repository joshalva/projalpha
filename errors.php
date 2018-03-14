<?php if (count($errorsalpha) > 0) : ?>
    <div class="error">
        <?php foreach ($errorsalpha as $error) : ?>
            <p><?php echo $error ?></p>
        <?php endforeach ?>
    </div>
    <?php
  endif ?>
