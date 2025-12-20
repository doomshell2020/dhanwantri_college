<input type="hidden" name="year" value="<?php echo $year; ?>">
<input type="hidden" name="class" value="<?php echo $class; ?>">
<input type="hidden" name="section" value="<?php echo $section; ?>">
<input type="hidden" name="enroll" value="<?php echo $enroll; ?>">
<input type="hidden" name="fname" value="<?php echo $fname; ?>">
<?php $page = $this->request->params['paging']['Students']['page'];
$limit = $this->request->params['paging']['Students']['perPage'];
$counter = ($page * $limit) - $limit + 1;
if (isset($students) && !empty($students)) {
	foreach ($students as $work) {
?>
		<tr>
			<td><input type="checkbox" id="chk12009" class="StuAttendCk" name="stud_id[]" value="<?php echo $work['id']; ?>">
			</td>


			<td><?php echo $work['id']; ?></td>

			<td><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>"><?php echo $work['fname']; ?></a></td>

			<td><?php echo $work['acedmicyear']; ?></td>
			<td><?php echo $work['classtitle']; ?></td>
			<td><?php echo $work['sectiontitle']; ?></td>
			<td><?php $rt = date('d-m-Y', strtotime($work['dob']));
				if ($rt != '01-01-1970') {
					echo $rt;
				} ?></td>
			<td><?php if ($work['fathername']) {
					echo $work['fathername'];
				} else {
					$ertd = $this->Comman->find_guardianname($work['id']);
					echo $ertd[0]['fullname'];
				} ?></td>
			<td><?php if ($work['status'] == 'Y') {
					echo $this->Html->link('Activate', [
						'action' => '#'

					], ['class' => 'label label-success']);
				} else {
					echo $this->Html->link('Deactivate', [
						'action' => '#',

					], ['class' => 'label label-primary']);
				} ?>
			</td>


		</tr>
	<?php $counter++;
	}
} else { ?>
	<tr>
		<td colspan="11" style="text-align:center;">NO Data Available</td>
	</tr>
<?php } ?>