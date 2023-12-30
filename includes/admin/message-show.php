<?php
if(!isset($_GET['message_id'])) {
    Semej::set('danger', 'error', 'Missing message id');
    header('Location: dashboard.php?page=categories');
}

$id = Sanitizer::sanitize($_GET['message_id']);
$_message = new Contact();
$message = $_message->show($id);
?>
<h2>show message:</h2>

<div class="col-sm-12">
    <form>
        <div class="form-group form-floating mb-3">
            <input value="<?php echo $message['name']; ?>" type="text" id="name" class="form-control" placeholder="Enter Title" readonly>
            <label for="name">Name</label>
        </div>
        <div class="form-group form-floating mb-3">
            <input value="<?php echo $message['email']; ?>" type="text" id="Email" class="form-control" placeholder="Enter Title" readonly>
            <label for="Email">Email</label>
        </div>
        <div class="form-group form-floating mb-3">
            <input value="<?php echo $message['phone']; ?>" type="text" id="Phone" class="form-control" placeholder="Enter Title" readonly>
            <label for="Phone">Phone</label>
        </div>
        <textarea name="message" id="message" cols="30" rows="10" class="form-control" readonly><?php echo $message['message']; ?></textarea>
            <hr>
        </div>
        <div class="form-group form-floating mb-3">
            <input value="<?php echo date("F j\. Y",strtotime($message['created_at'])); ?>" type="text" id="Create_at" class="form-control" placeholder="Enter Title" readonly>
            <label for="Create_at">Create_at</label>
        </div>
    </form>
</div>