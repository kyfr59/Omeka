<div class='comments'>
    <div id='comments-flash'><?php echo flash(true); ?></div>
    <?php echo fire_plugin_hook('commenting_prepend_to_comments', array('comments' =>$comments)); ?>

    <?php if($threaded) :?>
        <?php echo $this->partial('threaded-comments.php', array('comments' => $comments, 'parent_id'=>null)); ?>
    <?php else: ?>
        <?php foreach($comments as $comment): ?>
        <div id="comment-<?php echo $comment->id; ?>" class='comment'>
            <?php echo $this->partial('comment.php', array('comment' => $comment)); ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
jQuery(document).ready(function() {
    jQuery('#comment-form input').click(function() {
        jQuery(this).val('');
    });

    jQuery('#comment-form textarea').click(function() {
        jQuery(this).val("");
    });
});
</script>