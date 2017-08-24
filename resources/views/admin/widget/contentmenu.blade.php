<?php if( ! empty($contentMenu) and is_array($contentMenu) and count($contentMenu) > 1): ?>
<?php
	$mcaName = \App\Services\Admin\MCAManager::MAC_BIND_NAME;
    $MCA = app()->make($mcaName);
?>
<div class="content-menu">
    <div class="btn-group btn-group-sm" role="group" aria-label="...">
        <?php foreach($contentMenu as $key => $value): ?>
        <?php $urlParam = $value['module'] .'.'. $value['class'] .'.'. $value['action']; ?>
        <?php $checkThird = $MCA->matchThirdMenu($value['module'], $value['class'], $value['action']); ?>
        <?php
        	$style = '';
        	if($checkThird)
        	{
        		$style = 'background-color:#ebebeb; color:#333;';
        	}
        ?>
        <?php $arrData[] = '<button style="'.$style.'" type="button" class="btn btn-default content-menu-button" data-href="'.R('common', $urlParam).'" >'.$value['name'].'</button>'; ?>
        <?php endforeach; ?>
        <?php if(isset($arrData) and is_array($arrData)) echo implode('', $arrData); ?>
    </div>
</div>
<?php endif; ?>