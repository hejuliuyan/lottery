<div style="height:300px; overflow-y:auto;">
  <table class="table table-bordered table-striped table-condensed">
    <tr>
        <?php $tmp = 1; $perNums = 3; ?>
        <?php $count = count($list); ?>
        <?php $m = $count % $perNums; ?>
        <?php $list = array_pad($list, $count + ($perNums - $m), [])?>
        <?php foreach($list as $key => $value): ?>
            <td width="33%">
                <?php if(isset($value['name'])): ?>
                    <label><input type="checkbox" class="pl-position-id" value="<?php echo $value['id']; ?>" >&nbsp&nbsp<?php echo $value['name']; ?></label>
                <?php endif; ?>
            </td>
            <?php if($tmp % $perNums == 0): ?>
                </tr><tr>
            <?php endif; ?>
            <?php $tmp++; ?>
        <?php endforeach; ?>
  </table>
</div>