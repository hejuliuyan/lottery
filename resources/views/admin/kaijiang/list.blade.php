<tr>
  <td><input type="text" name="sort[<?php echo $value['id']; ?>]" value="<?php echo $value['sort']; ?>" style="width:50px;text-align:center;"></td>
  <td><span style="color:#ccc;"><?php echo $prefix; ?></span><?php echo $value['name']; ?></td>
  <td><?php echo $value['module'].'-'.$value['class'].'-'.$value['action']; ?></td>
  <td><?php echo $value['display'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?></td>
  <td><?php echo $value['mark']; ?></td>
  <td>
    <?php echo widget('Admin.Acl')->edit($value); ?>
    <?php echo widget('Admin.Acl')->delete($value); ?>
  </td>
</tr>