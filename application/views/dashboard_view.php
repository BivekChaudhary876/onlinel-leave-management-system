<?php 
$role = $_SESSION['current_user']['role']; 
?>

<div class="my-3">
    <?php if($role == 'admin'): ?>
        <div class="my-3 text-center d-flex justify-content-evenly">
            <!-- Form to select username -->
            <form method="post">
                <select name="selected_user" id="usernameDropdown" class="p-1 btn border-success rounded-start rounded-end">
                    <option value="0"><?php echo 'Select User' ?></option>
                    <?php foreach($usernames as $user): ?>
                        <option value="<?= $user ?>"><?= $user ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Submit" class="p-1 btn btn-outline-success">
            </form>
        </div>

        <!-- Display leave requests for the selected user -->
        <?php if(isset($selectedUserLeaveRequests) && !empty($selectedUserLeaveRequests)): ?>
            <div class="my-3 text-center">
                    <h2>Leave Requests for <?= $selected_user ?></h2>
            </div>
            <div class="my-3 text-center d-flex justify-content-evenly">
                <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br><?= $totalLeaveCount ?></button>
                <button id="pendingBtn" class="btn btn-outline-warning">Pending<br><?= $pendingLeaveCount ?></button>
                <button id="approvedBtn" class="btn btn-outline-success">Approved<br><?= $approvedLeaveCount ?></button>
                <button id="rejectedBtn" class="btn btn-outline-danger">Rejected<br><?= $rejectedLeaveCount ?></button>
            </div>
        <?php endif; ?>

    <?php elseif($role == 'user'): ?>
        <div class="text-center my-3">
            <h2>Leave Requests</h2>
        </div>
        <div class="my-3 text-center d-flex justify-content-evenly">
            <button id="totalLeaveBtn" class="btn btn-outline-info">Total Leaves<br><?= $totalLeaveCount ?></button>
            <button id="pendingBtn" class="btn btn-outline-warning">Pending<br><?= $pendingLeaveCount ?></button>
            <button id="approvedBtn" class="btn btn-outline-success">Approved<br><?= $approvedLeaveCount ?></button>
            <button id="rejectedBtn" class="btn btn-outline-danger">Rejected<br><?= $rejectedLeaveCount ?></button>
        </div>
    <?php endif; ?>
</div>
