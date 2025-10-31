<?php
/*
Template Name: Survey Response
*/

get_header(); 

while ( have_posts() ) :
    the_post();
    
    // Get the current post ID
    $response_id = get_the_ID();
    
    // Get post meta with corrected keys
    $survey_data = array(
        'survey_gender' => get_post_meta($response_id, 'survey_gender', true),
        'survey_age' => get_post_meta($response_id, 'survey_age', true),
        'survey_health_importance' => get_post_meta($response_id, 'survey_health_importance', true),
        'survey_health_motives' => maybe_unserialize(get_post_meta($response_id, 'survey_health_motives', true)),
        'survey_food_waste_frequency' => get_post_meta($response_id, 'survey_food_waste_frequency', true),
        'survey_food_waste_reasons' => maybe_unserialize(get_post_meta($response_id, 'survey_food_waste_reasons', true)),
        'survey_food_waste_motives' => maybe_unserialize(get_post_meta($response_id, 'survey_food_waste_motives', true)),
        'survey_message' => get_post_meta($response_id, 'survey_message', true)
    );
?>
    
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4"><?php the_title(); ?></h1>
        
        <div class="bg-white shadow rounded-lg p-6">
            <p class="mb-4"><strong>Gender:</strong> <?php echo esc_html($survey_data['survey_gender']); ?></p>
            <p class="mb-4"><strong>Age:</strong> <?php echo esc_html($survey_data['survey_age']); ?></p>
            <p class="mb-4"><strong>Healthy Eating Importance:</strong> <?php echo esc_html($survey_data['survey_health_importance']); ?></p>
            <p class="mb-4"><strong>Motivations:</strong> <?php 
                if(is_array($survey_data['survey_health_motives'])) {
                    echo esc_html(implode(', ', $survey_data['survey_health_motives']));
                } else {
                    echo esc_html($survey_data['survey_health_motives']);
                }
            ?></p>
            <p class="mb-4"><strong>Food Waste Frequency:</strong> <?php echo esc_html($survey_data['survey_food_waste_frequency']); ?></p>
            <p class="mb-4"><strong>Main Reasons:</strong> <?php 
                if(is_array($survey_data['survey_food_waste_reasons'])) {
                    echo esc_html(implode(', ', $survey_data['survey_food_waste_reasons']));
                } else {
                    echo esc_html($survey_data['survey_food_waste_reasons']);
                }
            ?></p>
            <p class="mb-4"><strong>Reduce Food Waste:</strong> <?php 
                if(is_array($survey_data['survey_food_waste_motives'])) {
                    echo esc_html(implode(', ', $survey_data['survey_food_waste_motives']));
                } else {
                    echo esc_html($survey_data['survey_food_waste_motives']);
                }
            ?></p>
            <p class="mb-4"><strong>Message:</strong> <?php echo esc_html($survey_data['survey_message']); ?></p>
        </div>
        
        <div class="mt-8">
            <a href="<?php echo esc_url(home_url('/sustainability')); ?>" 
               class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600 transition">
                Back to Survey
            </a>
        </div>
    </div>

<?php 
endwhile;

get_footer();