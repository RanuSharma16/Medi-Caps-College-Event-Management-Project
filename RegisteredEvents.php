<?php
require_once 'utils/header.php';
require_once 'utils/styles.php';

$usn=$_POST['usn'];

include_once 'classes/db1.php';

// query for registered events
$registered_result = mysqli_query($conn, "SELECT * FROM registered r,staff_coordinator s ,event_info ef ,student_coordinator st,events e where e.event_id= ef.event_id and e.event_id= s.event_id and e.event_id= st.event_id and r.usn= '$usn' and r.event_id=e.event_id");

// query for not registered events
$not_registered_result = mysqli_query($conn, "SELECT * FROM events e, event_info ef, staff_coordinator s, student_coordinator st WHERE e.event_id=ef.event_id AND e.event_id=s.event_id AND e.event_id=st.event_id AND e.event_id NOT IN (SELECT event_id FROM registered WHERE usn='$usn')");

?>

<div class = "content">
    <div class = "container">
        <h1>Registered Events</h1>
        <?php if (mysqli_num_rows($registered_result) > 0) { ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>             
                        <th>Student Co-ordinator</th>
                        <th>Staff Co-ordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($registered_result)) { ?>
                        <tr>
                            <td><?php echo $row['event_title']; ?></td>
                            <td><?php echo $row['st_name']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['Date']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Not Yet Registered any events</p>
        <?php } ?>
    </div>
</div>

<div class = "content">
    <div class = "container">
        <h1>Not Registered Events</h1>
        <?php if (mysqli_num_rows($not_registered_result) > 0) { ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>             
                        <th>Student Co-ordinator</th>
                        <th>Staff Co-ordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($not_registered_result)) { ?>
                        <tr>
                            <td><?php echo $row['event_title']; ?></td>
                            <td><?php echo $row['st_name']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['Date']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No events found</p>
        <?php } ?>
    </div>
</div>
<div class = "content">
    <div class = "container">
        <h1>Register for Events</h1>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="usn">USN:</label>
                <input type="text" class="form-control" id="usn" name="usn" required>
            </div>
            <div class="form-group">
                <label for="event_id">Event:</label>
                <select class="form-control" id="event_id" name="event_id" required>
                    <?php
                        // fetch events from database
                        $events_result = mysqli_query($conn, "SELECT * FROM events");
                        while($row = mysqli_fetch_array($events_result)) {
                            echo '<option value="'.$row['event_id'].'">'.$row['event_title'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</div>

