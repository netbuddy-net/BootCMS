<?php
/**
 * WordPress classic theme
 * inc/bootcms-editor.php
 * @link https://github/...
 * @package BootCMS
 * @since 2.0
 */
defined( 'ABSPATH' ) || exit; // Exit if accessed directly
/* =========================================================
   BootCMS Large Editor
   ========================================================= */ 

class BootCMS_Large_Editor_Widget extends WP_Widget {
  public function __construct() {
	parent::__construct(
	  'bootcms_large_editor',
	  __( 'BootCMS Large HTML Editor', 'bootcms' ),
	  array(
		'description' => __( 'BootCMS large HTML editor for use in widget areas.', 'bootcms' ),
	  )
	);
  }
  public function widget( $args, $instance ) {
	echo $args['before_widget'];
	if ( ! empty( $instance['title'] ) ) {
	  echo $args['before_title'];
	  echo esc_html( $instance['title'] );
	  echo $args['after_title'];
	}		
	if ( ! empty( $instance['content'] ) ) {
	  echo $instance['content'];
    }
	  echo $args['after_widget'];
  }
  public function form( $instance ) {
	$title   = ! empty( $instance['title'] ) ? $instance['title'] : '';
	$content = ! empty( $instance['content'] ) ? $instance['content'] : '';
?>
<p>
  <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
  <?php esc_html_e( 'Title:', 'bootcms' ); ?>
  </label>
  <input
	class="widefat"
	id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
	name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
	type="text"
	value="<?php echo esc_attr( $title ); ?>" >
</p>
<p>
  <button type="button" class="button button-secondary bootcms-open-large-editor"
	data-textarea="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" 
	data-editor-mode="widget">
	<?php esc_html_e( 'Open Large HTML Editor', 'bootcms' ); ?>
  </button>
</p>
<textarea
  class="bootcms-widget-content sync-input"
  id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"
  name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>"
  style="display:none;" >
  <?php echo esc_textarea( $content ); ?>
</textarea>
<?php
  }
  public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = sanitize_text_field(
	  $new_instance['title'] ?? ''
	);
	$instance['content'] = $new_instance['content'] ?? '';
	return $instance;
  }
}
// Editor in Customizer
if ( ! class_exists( 'WP_Customize_Control' ) ) {
  require_once ABSPATH . WPINC . '/class-wp-customize-control.php';
}
class BootCMS_Large_Editor_Control extends WP_Customize_Control {
  public $type = 'bootcms_large_editor';
  public $editor_mode = 'customizer';
  public function render_content() {
?>
<textarea
  id="<?php echo esc_attr( $this->id ); ?>"
  class="bootcms-customizer-editor sync-input"
  style="display:none;" >
  <?php echo esc_textarea( $this->editor_mode === 'javascript' ? '' : $this->value() ); ?>
</textarea>
<button
  type="button"
  class="button button-secondary bootcms-open-large-editor"
  data-textarea="<?php echo esc_attr( $this->id ); ?>"
  data-editor-mode="<?php echo esc_attr( $this->editor_mode ); ?>" >
  <?php esc_html_e( 'Open Script Editor', 'bootcms' ); ?>
</button>
<?php
  }
}
/**
 * Register BootCMS Large Editor App
 */
function bootcms_register_large_editor_widget() {
  register_widget( 'BootCMS_Large_Editor_Widget' );
}
add_action( 'widgets_init', 'bootcms_register_large_editor_widget' );

function bootcms_large_editor_modal() {
?>
<div id="bootcms-modal-backdrop"></div>
  <div id="bootcms-large-editor-modal" class="bootcms-editor-modal" style="display:none;">
	<div class="bootcms-editor-window">
	  <div class="bootcms-editor-header">
		<span><?php esc_html_e( 'BootCMS Large HTML Editor', 'bootcms' ); ?></span>
		<span>
		  <button type="button" class="bootcms-modal-minimise">&minus;</button>
		  <button type="button" class="bootcms-modal-maximise">&#9633;</button>
		  <button type="button" class="bootcms-editor-close" aria-label="<?php esc_attr_e( 'Close', 'bootcms' ); ?>">
			&times;
		  </button>
		</span>
	  </div>
	  <div class="bootcms-editor-content">				
		<textarea id="bootcms-large-editor" name="bootcms_large_editor"></textarea>							
	  </div>
	  <div class="bootcms-editor-footer">
		<div id="bootcms-javascript-buttons" style="display:none;margin-right:auto;">
		  <select id="bootcms-javascript-file">
			<option value="">Select a JavaScript file</option>
		  </select>
		  <button type="button" class="button button-secondary bootcms-javascript-open">
			<?php esc_html_e( 'Open', 'bootcms' ); ?>
		  </button>
		  <button type="button" class="button button-secondary bootcms-javascript-save">
			<?php esc_html_e( 'Save', 'bootcms' ); ?>
		  </button>
		</div>
		<button type="button" class="button button-secondary bootcms-modal-close" aria-label="<?php esc_attr_e( 'Close', 'bootcms' ); ?>" >
		  <span>Close</span>
		</button>
	  </div>
	</div>
  </div>
<?php
}
add_action( 'admin_footer-widgets.php', 'bootcms_large_editor_modal' );
add_action( 'customize_controls_print_footer_scripts', 'bootcms_large_editor_modal' );

function bootcms_large_editor_script() {
  static $loaded = false;
  if ( $loaded ) { return; }
  $loaded = true;
?>
  <script>
  	var bootcmsEditorAjax = {
	  url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
	  nonce: '<?php echo esc_js( wp_create_nonce( 'bootcms_edit_javascript' ) ); ?>'
	};
	jQuery(function($) {
	  var $modal = $('#bootcms-large-editor-modal');
	  $(document).on('click', '.bootcms-open-large-editor', function() {
		var textarea = $('#' + $(this).data('textarea'));
		$modal.data('textarea', textarea);
		$modal.data('editor-mode', $(this).data('editor-mode'));
		$('#bootcms-javascript-buttons').hide();
		$('#bootcms-javascript-file-selector').hide();
		if ( $modal.data('editor-mode') === 'javascript' ) {
		  $('#bootcms-javascript-buttons').show();
		  $('#bootcms-javascript-file-selector').show();
		  var $select = $('#bootcms-javascript-file');
		  window.bootcmsEditor.codemirror.setOption('mode', 'text/javascript');
		  $select.empty();
		  $select.append('<option value="">Select a JavaScript file</option>');
		  $.post(bootcmsEditorAjax.url, {
			action: 'bootcms_get_javascript_files',
			nonce: bootcmsEditorAjax.nonce
		  }, function(response) {
			if (response.success) {
			  $.each(response.data, function(index, file) {
				$select.append(
				  $('<option>', {
					value: file,
					text: file
				  })
				);
			  });
			}
		  });
		}
		$modal.show();
		$('#bootcms-large-editor-modal').addClass('bootcms-modal-ismaximised');
		$('#bootcms-modal-backdrop').show();		
		setTimeout(function() {
          window.bootcmsEditor.codemirror.setValue(textarea.val());
          window.bootcmsEditor.codemirror.refresh();
		}, 0);	
	  });
	  $(document).on('click', '.bootcms-javascript-open', function() {
		var file = $('#bootcms-javascript-file').val();
		if ( ! file ) { return; }
		$.post(bootcmsEditorAjax.url, {
		  action: 'bootcms_get_chosen_js_file',
		  nonce: bootcmsEditorAjax.nonce,
		  file: file
		}, function(response) {
		  if (response.success) {
			window.bootcmsEditor.codemirror.setValue(response.data.content);
			window.bootcmsEditor.codemirror.refresh();
			$('#bootcms-javascript-file-selector').hide();
		  }
		});
	  });
	  $(document).on('click', '.bootcms-javascript-save', function() {
		var file = $('#bootcms-javascript-file').val();
		var content = window.bootcmsEditor.codemirror.getValue();
		if ( ! file ) { return; }
		$.post(bootcmsEditorAjax.url, {
		  action: 'bootcms_save_chosen_js_file',
		  nonce: bootcmsEditorAjax.nonce,
		  file: file,
		  content: content
		}, function(response) {
		  if (response.success) {
			alert('<?php echo esc_js( __( 'File saved', 'bootcms' ) ); ?>');
		  } else {
			console.error(
			  '<?php echo esc_js( __( 'Save failed:', 'bootcms' ) ); ?>', response.data
			);
		  }
		});
	  });
	  bootcmsEditor.codemirror.on("change", function() {
		var textarea = $modal.data("textarea");
		if ( textarea ) {
		  textarea.val(bootcmsEditor.codemirror.getValue());
		  textarea.trigger("change");
		}
	  });
	  $(document).on('click', '.bootcms-editor-close, .bootcms-modal-close', function() {
		$('#bootcms-modal-backdrop').hide();
		$('#bootcms-large-editor-modal').attr('class', 'bootcms-editor-modal').removeAttr('style').hide();
	  });  
	  $(document).on('click', '.bootcms-modal-minimise', function() {  
		$modal.css({'transform': 'translate(-45%, 30%) scale(0.07)'}); 
		if ($('#bootcms-large-editor-modal').hasClass('bootcms-modal-ismaximised')) {
		  $('#bootcms-large-editor-modal').removeClass('bootcms-modal-ismaximised');
		}		
		$modal.addClass('bootcms-modal-isminimised');
		$('.bootcms-editor-window').hide();
		$('#bootcms-modal-backdrop').hide();
		const rect = $modal[0].getBoundingClientRect();
		let x = 0;
		let y = 0;
		if (rect.left < 0) {
          x = -rect.left;
		}
		if (rect.right > window.innerWidth) {
          x = window.innerWidth - rect.right;
		}
		if (rect.top < 0) {
          y = -rect.top;
		}
		if (rect.bottom > window.innerHeight) {
          y = window.innerHeight - rect.bottom;
		}
		if (x || y) {
          $modal[0].style.transform = `translate(calc(-45% + ${x}px), calc(30% + ${y}px)) scale(0.07)`;
		}				
	  });	  
	  $(document).on('click', '#bootcms-large-editor-modal.bootcms-modal-isminimised', function() {
		$(this).css({'transform': 'translate(0, 0) scale(1)'}); 
		$(this).removeClass('bootcms-modal-isminimised');
		$('.bootcms-editor-window').show();
		if ($(this).hasClass('bootcms-modal-moved') || $(this).hasClass('bootcms-modal-resized')) {
		  $('#bootcms-modal-backdrop').hide();
		} else {
		  $('#bootcms-modal-backdrop').show();
		  $(this).addClass('bootcms-modal-ismaximised');		
		}	
	  });	  
	  $(document).on('click', '.bootcms-modal-maximise', function() {
		$modal.removeClass('bootcms-modal-moved');
		$modal.removeClass('bootcms-modal-resized');
		$modal.removeAttr('style'); 
		$('#bootcms-modal-backdrop').show();
	  }); 	
	  let isDragging = false;
	  let offsetX = 0;
	  let offsetY = 0;
	  $(document).on('mousedown', '.bootcms-editor-header', function(e) {
		e.stopPropagation();
		isDragging = true;
		offsetX = e.clientX - $modal.offset().left;
		offsetY = e.clientY - $modal.offset().top;
		e.preventDefault();
	  });
	  $(document).on('mousemove', function(e) {
		if (!isDragging) return;
		$('#bootcms-large-editor-modal').addClass('bootcms-modal-moved');
		$('#bootcms-modal-backdrop').hide();
		$('#bootcms-large-editor-modal').css({
          left: e.clientX - offsetX,
          top: e.clientY - offsetY
		});
	  });
	  $(document).on('mouseup', function() {
		isDragging = false;
	  });
	  $(document).on('mousedown', '#bootcms-large-editor-modal', function(e) {
		const rect = this.getBoundingClientRect();
		if ( e.clientX >= rect.right - 20 && e.clientY >= rect.bottom - 20 ) {
          $('#bootcms-modal-backdrop').hide();
		  $(this).removeClass('bootcms-modal-ismaximised');
          $(this).addClass('bootcms-modal-resized');
		}
	  });
	});
  </script>
<?php
}
add_action( 'admin_footer-widgets.php', 'bootcms_large_editor_script' );
add_action( 'customize_controls_print_footer_scripts', 'bootcms_large_editor_script' );

function bootcms_get_javascript_files() {	
  if ( ! current_user_can( 'edit_themes' ) ) {
	wp_send_json_error( 'Permission denied.', 403 );
  }
  check_ajax_referer( 'bootcms_edit_javascript', 'nonce' );
  $js_dir = get_template_directory() . '/js/';
  $files  = glob( $js_dir . '*.js' );
  $result = array();
  foreach ( $files as $file ) {
	$result[] = basename( $file );
  }
  wp_send_json_success( $result );
}
add_action( 'wp_ajax_bootcms_get_javascript_files', 'bootcms_get_javascript_files' );

function bootcms_get_chosen_js_file() {
  if ( ! current_user_can( 'edit_themes' ) ) {
	wp_send_json_error( 'Permission denied.', 403 );
  }
  check_ajax_referer( 'bootcms_edit_javascript', 'nonce' );
  $file = isset( $_POST['file'] ) ? sanitize_file_name( $_POST['file'] ) : '';
  if ( ! $file || substr( $file, -3 ) !== '.js' ) {
	wp_send_json_error( 'Invalid file.' );
  }
  $js_dir  = get_template_directory() . '/js/';
  $filepath = $js_dir . $file;
  if ( ! file_exists( $filepath ) ) {
	wp_send_json_error( 'File not found.' );
  }
  wp_send_json_success(
	array(
	  'file'    => $file,
	  'content' => file_get_contents( $filepath ),
  ) );
}
add_action( 'wp_ajax_bootcms_get_chosen_js_file', 'bootcms_get_chosen_js_file' );

function bootcms_save_chosen_js_file() {
  if ( ! current_user_can( 'edit_themes' ) ) {
	wp_send_json_error( 'Permission denied.', 403 );
  }
  check_ajax_referer( 'bootcms_edit_javascript', 'nonce' );
  $file = isset( $_POST['file'] ) ? sanitize_file_name( $_POST['file'] ) : '';
  $content = isset( $_POST['content'] ) ? wp_unslash( $_POST['content'] ) : '';
  if ( ! $file || substr( $file, -3 ) !== '.js' ) {
	wp_send_json_error( 'Invalid file.' );
  }
  $js_dir  = get_template_directory() . '/js/';
  $filepath = $js_dir . $file;
  if ( ! file_exists( $filepath ) ) {
	wp_send_json_error( 'File not found.' );
  }
  if ( false === file_put_contents( $filepath, $content ) ) {
	wp_send_json_error( 'Unable to save file.' );
  }
  wp_send_json_success(
	array(
	  'file' => $file,
	)
  ); 
}
add_action( 'wp_ajax_bootcms_save_chosen_js_file', 'bootcms_save_chosen_js_file' );

function bootcms_large_editor_assets() {
  $settings = wp_enqueue_code_editor(
	array(
	  'type'       => 'text/html',
	  'codemirror' => array(
	  'indentUnit' => 2,
	  'tabSize'    => 2,
	  ),
	)
  );
  if ( false === $settings ) {
	return;
  }
  wp_add_inline_script(
	'code-editor',
	sprintf(
	  'jQuery(function($) {							
		var bootcmsEditor = window.bootcmsEditor = wp.codeEditor.initialize(
		  "bootcms-large-editor",
		  %s
		);
		bootcmsEditor.codemirror.on("change", function() {
		  var modal = $("#bootcms-large-editor-modal");
		  var widget = modal.data("widget");
		  if ( widget ) {
			var textarea = widget.find(".bootcms-widget-content");
			textarea.val(
			  bootcmsEditor.codemirror.getValue()
			);
			textarea.trigger("change");
		  }
		});
	  });',
	  wp_json_encode( $settings )
	)
  );
}
add_action( 'admin_enqueue_scripts', function( $hook ) {
  if ( 'widgets.php' !== $hook ) {
        return;
  }
    bootcms_large_editor_assets();
} ); 
function bootcms_large_editor_style() {
  ?>
  <style>
	#bootcms-large-editor-modal {
	  resize: both;
	  overflow: auto;
	  transition: transform 0.5s ease;
	  position: fixed;
      width: 90%;
      height: 90%;
      top: 5%;
      left: 5%;
	  z-index: 99999;
	  background: rgba(0,0,0,.6);
	}
	.bootcms-editor-window {
	  position: absolute;
	  top: 5px;
	  left: 5px;
	  width: calc(100% - 10px);
	  height: calc(100% - 10px);
	  background: #fff;
	}
	.bootcms-editor-header {
	  height: 40px;
	  padding: 25px;
	  display: flex;
	  align-items: center;
	  justify-content: space-between;
	  background: #f0f0f1;
	  border-bottom: 1px solid #ccc;
	  box-sizing: border-box;
	  cursor: all-scroll;
	}
	.bootcms-editor-header button {
	  cursor: pointer;
	}
	.bootcms-editor-footer {
	  height: 60px;
	  padding: 0px 30px;
	  display: flex;
	  align-items: center;
	  justify-content: flex-end;
	  border-bottom: 1px solid #ccc;
	  box-sizing: border-box;
	}
	.bootcms-modal-minimise,
	.bootcms-modal-maximise,
	.bootcms-editor-close {
	  border: 0;
	  background: none;
	  font-size: 24px;
	  cursor: pointer;
	}
	.bootcms-modal-close {
	  height: 25px;	
	}
	.bootcms-editor-content {
	  padding: 30px 30px 5px 30px;
	  height: calc(100% - 110px);
	  box-sizing: border-box;
	}
	#bootcms-large-editor {
	  width: 100%;
	  height: 100%;
	}
	.CodeMirror-gutter.CodeMirror-linenumbers {
	  width: 30px !important;	
	}		
	[class*="bootcms_large_editor-"] .widget-title::before,
	[class*="bootcms_large_editor-"] h3,
	[class*="bootcms_large_editor-"] div.widget-description {
	  color: maroon !important;	
	}
	.CodeMirror-wrap {
	  border: 1px solid lightgrey;	
	}
	.bootcms-editor-content .CodeMirror {
	  height: 100% !important;	
	}
	#bootcms-large-editor-modal.bootcms-modal-isminimised {
	  background: white;
	  border: 40px solid darkgray;
	  box-shadow: 105px 105px 105px 0px rgba(0, 0, 0, 0.1);
	  border-radius: 3px;
	  cursor: pointer;
	}
	#bootcms-large-editor-modal.bootcms-modal-isminimised::before {
	  content: "📝";
	  display: block;
	  font-size: 70cqh;
	  position: absolute;
	  left: 50%;
	  top: 50%;
	  transform: translate(-50%, -50%);
	}
	#bootcms-large-editor-modal::after {
	  content: "\00A0↘";
	  color: white;
	  background: red;
	  font-weight: bold;
	  position: absolute;
	  right: 5px;
	  bottom: 4px;
	  font-size: 15px;
	  line-height: 15px;
	  pointer-events: none;
	  border-top-left-radius: 3px;
	}
	#bootcms-modal-backdrop {
	  display: none;
	  position: fixed;
	  inset: 0;
	  background: rgba(0, 0, 0, 0.6);
	  z-index: 99988;
	}
  </style>
  <?php
}
add_action( 'admin_footer-widgets.php', 'bootcms_large_editor_style' );