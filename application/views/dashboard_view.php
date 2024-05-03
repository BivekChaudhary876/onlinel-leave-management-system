<div class="container">
    <div class="my-3">
        <h1 class="text-center">Dashboard</h1>
    </div>
    <div class="row py-4 d-flex justify-content-evenly gap-lg-4" id="droppable"style="">
        <div class="p-3 col-5 rounded-4 " id="widget1" style="border:1px solid #000;flex: 1; min-height: 200px;">
            <h5>Recent Leave Requests By Status</h5>
        </div>
        <div class="p-3 col-5 rounded-4" id="widget2"  style="border:1px solid #000;flex: 1; min-height: 200px;">
            <h5>Recent Leave Requests By Employee</h5>
            <div class="my-3">
                <table class="table">
                    <tbody>
                        <?php 
                        $count =0;
                        foreach( $total_leave_requests as $key => $leave ) : 
                            if( $count >= 5):
                                break;
                            endif;?>
                            <tr> 
                                <td><?php  echo ( indexing() + $key+1 ) ; ?></td>
                                <?php if( is_admin() ): ?>
                                        <td><?php echo $leave[ 'username' ]; ?></td>
                                <?php endif; ?>
                                <td class="status"><?php echo get_status_badge( $leave[ 'status' ] ) ?></td>
                                <td>
                                    <a href='leave/details/<?php echo $leave[ 'id' ]; ?>'"><span class="btn text-secondary">View </span></a>
                                </td>
                            </tr>
                        <?php 
                        $count++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="my-3">
      <!-- Total and status counts -->
        <div class="row">
            <div class="my-3 text-center d-flex justify-content-evenly flex-container">
                <p id="totalLeaveBtn" class="text-">Total Leaves <?php echo $total_leaves ?></p>
                <p id="pendingBtn" class="text-">Pending <?php echo $total_pending ?></p>
                <p id="approvedBtn" class="text-">Approved <?php echo $total_approved ?></p>
                <p id="rejectedBtn" class="text-">Rejected <?php echo $total_rejected ?></p>
            </div>
        </div>
    </div>
</div>


<script>
    
$(document).ready(function () {

    $("#totalLeaveBtn, #pendingBtn, #approvedBtn, #rejectedBtn").draggable({
        containment: "document",
        revert: "invalid",
        stack: ".draggable",
        zIndex: 1000,
    });
    // Enable droppable behavior for the col-5umns
    $(".col-5").droppable({
        accept: "#totalLeaveBtn, #pendingBtn, #approvedBtn, #rejectedBtn",
        drop: function (event, ui) {
            const droppedItem = ui.draggable;
            $(this).append(droppedItem);
            droppedItem.css({
                top: 0,
                left: 0,
                position: "relative",
            });
            saveWidgetOrder();
        },
    });
    // Function to save widget order to local storage
    function saveWidgetOrder() {
        let widgetOrder = {
            widget1: $("#widget1").children().map((_, item) => item.id).get(),
            widget2: $("#widget2").children().map((_, item) => item.id).get(),
        };

        localStorage.setItem("widgetOrder", JSON.stringify(widgetOrder));
    }
    // Restore the widget order from local storage on page load
    const savedWidgetOrder = localStorage.getItem("widgetOrder");
    if (savedWidgetOrder) {
        const order = JSON.parse(savedWidgetOrder);

        order.widget1.forEach((widgetId) => {
            $("#" + widgetId).appendTo("#widget1");
        });
        order.widget2.forEach((widgetId) => {
            $("#" + widgetId).appendTo("#widget2");
        });
    }
});
</script>

