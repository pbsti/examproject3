<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="mt-12">
    <?php if ( have_comments() ) : ?>
        <h3 class="text-2xl font-bold mb-6">
            <?php
            printf(
                _nx('One response', '%1$s responses', get_comments_number(), 'comments title', 'textdomain'),
                number_format_i18n(get_comments_number())
            );
            ?>
        </h3>
        <ol class="space-y-6">
            <?php
            wp_list_comments([
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 48,
                'callback'   => function($comment, $args, $depth) {
                    $margin_class = $depth > 1 ? 'ml-[' . (20 * ($depth - 1)) . 'px]' : '';
                    $margin_bottom = $depth > 1 ? 'mb-4' : 'mt-12';
                    ?>
                    <li <?php comment_class("flex items-start gap-4 bg-gray-100 p-4 $margin_class $margin_bottom"); ?> id="comment-<?php comment_ID(); ?>">
                        <div>
                            <?php echo get_avatar($comment, 48, '', ''); ?>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-emerald-500"><?php echo get_comment_author(); ?></span>
                                <span class="text-xs text-gray-500"><?php echo get_comment_date('F j, Y \a\t H:i'); ?></span>
                            </div>
                            <div class="text-base text-black mb-2"><?php comment_text(); ?></div>
                            <div class="text-xs">
                                <?php
                                comment_reply_link(array_merge($args, [
                                    'reply_text' => 'Reply',
                                    'depth'      => $depth,
                                    'max_depth'  => $args['max_depth'],
                                    'class'      => 'text-emerald-500 hover:underline'
                                ]));
                                ?>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            ]);
            ?>
        </ol>
    <?php endif; ?>
    
    <div class="mt-6">
        <?php
        if ( comments_open() ) {
            comment_form([
                'class_submit' => 'bg-emerald-500 text-white px-6 py-2 rounded-lg font-bold hover:bg-green-600 transition cursor-pointer',
                'title_reply'  => '<span class="text-lg font-bold py-2">Leave a reply</span>',
                'comment_field'=> '<textarea id="comment" name="comment" class="w-full border border-gray-300 rounded-lg p-2 my-2" rows="4" required></textarea>',
            ]);
        }
        ?>
    </div>
</div>