<?php
$months[01] = 'Janvier';
$months[02] = 'Février';
$months[03] = 'Mars';
$months[04] = 'Avril';
$months[05] = 'Mai';
$months[06] = 'Juin';
$months[07] = 'Juillet';
$months[08] = 'Août';
$months[09] = 'Septembre';
$months[10] = 'Octobre';
$months[11] = 'Novembre';
$months[12] = 'Décembre';
?>
<div class='comment-author'>
    <?php
        if(!empty($comment->author_name)) {
            if(empty($comment->author_url)) {
                $authorText = $comment->author_name;
            } else {
                $authorText = "<a href='{$comment->author_url}'>{$comment->author_name}</a>";
            }
        } else {
            $authorText = __("Anonymous");
        }
    ?>
    <p class='comment-author-name'><?php echo $authorText?></p>
    <?php
        $hash = md5(strtolower(trim($comment->author_email)));
        $url = "//www.gravatar.com/avatar/$hash";
        echo "<img class='gravatar' src='$url' />";
    ?>
</div>
<p class="comment-infos">
    <?php $timestamp = strtotime($comment->added) ?>
    <?php $month = strtolower($months[(int)strftime('%m', $timestamp)]); ?>
    <span class="date"><?php echo strftime('%d '.$month.' %Y à %Hh%M', $timestamp ) ?>&nbsp;|&nbsp;</span>
    <span class='comment-reply'><?php echo __("Reply"); ?></>
 </p>   
<div class='comment-body <?php if($comment->flagged):?>comment-flagged<?php endif;?> '><?php echo $comment->body; ?></div>
<?php if(is_allowed('Commenting_Comment', 'unflag')): ?>
<p class='comment-flag' <?php if($comment->flagged): ?> style='display:none;'<?php endif;?> ><?php echo __("Flag inappropriate"); ?></p>
<p class='comment-unflag' <?php if(!$comment->flagged): ?>style='display:none;'<?php endif;?> ><?php echo __("Unflag inappropriate"); ?></p>
<?php endif; ?>

