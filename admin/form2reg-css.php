<style>
    :root{
        --form2reg-form-bg: <?php 
            if(get_option('form2reg_form_bg')){
                echo get_option( 'form2reg_form_bg' );
            }else{
                echo '#ffffff';
            }
        ?>;
        --form2reg-body-bg: <?php 
            if(get_option('form2reg_body_bg')){
                echo get_option( 'form2reg_body_bg' );
            }else{
                echo '#f5f5f5';
            }
        ?>;
        --form2reg-form-title: <?php 
            if(get_option('form2reg_form_title')){
                echo get_option( 'form2reg_form_title' );
            }else{
                echo '#2c3e50';
            }
        ?>;
        --form2reg-form-label: <?php 
            if(get_option('form2reg_form_label')){
                echo get_option( 'form2reg_form_label' );
            }else{
                echo '#777';
            }
        ?>;
        --form2reg-next-button: <?php 
            if(get_option('form2reg_next_button')){
                echo get_option( 'form2reg_next_button' );
            }else{
                echo '#ff9a76';
            }
        ?>;
        --form2reg-form-width: <?php 
            if(get_option('form2reg_form_width')){
                echo get_option( 'form2reg_form_width' );
            }else{
                echo '550px';
            }
        ?>;
    }
</style>