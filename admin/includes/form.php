<?php if(!empty($articol->errors)): ?>
    <div>
        <ul>
            <?php foreach ($articol->errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post">
    <div class="form-group">
        <label for="titlu">Title:</label>
        <input class="form-control" type="text" name="titlu" id="titlu" value="<?= htmlspecialchars($articol->titlu) ?? "" ?>">
    </div>
    <div class="form-group">
        <label for="continut">Content</label>
        <textarea class="form-control" name="continut" rows="10" placeholder="Article content" id="continut"><?= htmlspecialchars($articol->continut) ?? "" ?></textarea>
    </div>
    <div class="form-group">
        <label for="data_publicarii">Publication date and time</label>
        <input class="form-control" type="datetime-local" name="data_publicarii" id="data_publicarii" value="<?= htmlspecialchars($articol->data_publicarii) ?? "" ?>">
    </div>

    <button class="btn btn-light">Save</button>

</form>