<div class="wrap wcp-main-wrap">
    <h2><?php _e( 'Custom Fields Builder', 'real-estate-manager' ); ?></h2>

    <?php
        $field_types = array(
            'text',
            'number',
            'select',
        );
        $saved_fields = get_option( 'rem_p_fields' );
    ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 20%; text-align: center;">
                <ul class="hard-coded-list">
                    <?php foreach ($field_types as $type) {
                        echo '<li data-type="'.$type.'">';
                            include 'fields/'.$type.'.php';
                        echo '</li>';
                    } ?>
                </ul>
            </td>
            <td style="width: 80%;" class="form-meta-setting">
                <ul>
                    <?php
                        if(isset($saved_fields) && is_array($saved_fields)) {
                            foreach ($saved_fields as $data) {
                                echo '<li data-type="'.$data['type'].'">';
                                    include 'fields/'.$data['type'].'.php';
                                echo '</li>';
                            }
                        } else {
                            $fields = $this->single_property_fields();
                            foreach ($fields as $data) {
                                echo '<li data-type="'.$data['type'].'">';
                                    include 'fields/'.$data['type'].'.php';
                                echo '</li>';
                            }
                        }
                    ?>
                </ul>
                <p class="description">
                    <?php _e( 'Please Drag and Drop the fields in above area from left panel', 'real-estate-manager' ); ?>
                </p>
            </td>
        </tr>
    </table>
    <div>
        <h3>Please purchase <a target="_blank" href="https://codecanyon.net/item/real-estate-manager-pro/20482813?ref=WebCodingPlace">pro version</a> to activate this feature.</h3>
    </div>
</div>
<style>
    .wcp-main-wrap .ui-accordion-content {
        border-top-color: #ddd;
        border-top: 1px solid #ddd;
        padding: 15px;
        outline: none;
    }
    .wcp-main-wrap .ui-accordion-header {
        color: #333;
        background-color: #f5f5f5;
        border-color: #ddd;
        display: block;
        padding: 6px 15px;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px; 
        border-bottom: 0;
        font-size: 13px;
        cursor: move;
    }
    .form-meta-setting li {
        margin-bottom: 0;
        border-radius: 4px;
        border-color: #ddd;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }

    .ui-state-highlight {
        height: 30px;
        background-color: yellow;
        width: 100%;
    }
    .ui-draggable-dragging .inside-contents , .hard-coded-list .inside-contents {
        display: none;
    }
    .form-meta-setting ul {
        max-width: 520px;
        margin: 0 auto;
        border: 1px dotted #ddd;
        padding: 15px;
    }
    .form-meta-setting p.description {
        max-width: 520px;
        margin: 0 auto;
        padding: 15px;
    }
    .ui-draggable-dragging, .ui-sortable-helper {
        max-width: 500px !important;
        width: 100% !important;
    }
    .wcp-main-wrap table tbody {
        vertical-align: top;
    }
    .hard-coded-list li span {
        cursor: move !important;
    }
    .inside-contents table tbody {
        vertical-align: middle;
    }
    .form-meta-setting ul {
        min-height: 250px;
    }
    .remove-field {
        float: right;
        margin-top: 5px;
    }
</style>