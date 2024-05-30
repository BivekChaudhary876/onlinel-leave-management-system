<?php
class Media_Controller extends Base_Controller {
    protected $post_methods = [ 'save', 'delete' ];
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $files = $this->model->get();
        $total = $this->model->get_count();

        $this->load_view( [  
            'page_title' => 'Media',
            'files'      => $files,
            'total'      => $total,
        ], 'media' );
    }

    public function details( $id ) {
        if ( !$id ) {
            redirect( 'media' );
        }

        $details = $this->model->get( 
        	[ 'id' => $id ], 
        	true
        );

        if ( !$details ) {
            redirect( 'media' );
        }

        $this->load_view( [ 
            'page_title' => 'File Details',
            'details'    => $details,
        ], 'media_details' );
    }

    public function list() {
        $files = $this->model->get([], false);
        $this->load_view([
            'files' => $files
        ], 'media_list');
    }

    public function save( $id = null ) {
        if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
            if ( isset( $_FILES[ "file_to_upload" ] ) ) {
                $target_dir = "public/uploads/";
                $target_file = $target_dir . basename( $_FILES[ "file_to_upload" ][ "name" ] );
                $uploadOk = 1;
                $imageFileType = strtolower( pathinfo( $target_file, PATHINFO_EXTENSION ) );

                if ( isset( $_POST[ "submit" ] ) ) {
                    $check = getimagesize( $_FILES[ "file_to_upload" ][ "tmp_name" ] );
                    if ( $check !== false ) {
                        $uploadOk = 1;
                    } else {
                        $uploadOk = 0;
                    }
                }

                if ( $_FILES[ "file_to_upload" ][ "size" ] > 50000000 ) {
                    $uploadOk = 0;
                }

                if ( !in_array( $imageFileType, [ "jpg", "png", "jpeg", "gif" ] ) ) {
                    $uploadOk = 0;
                }

                if ( $uploadOk == 0 ) {
                    echo "Sorry, your file was not uploaded.";
                } else {
                    if ( move_uploaded_file( $_FILES[ "file_to_upload" ][ "tmp_name" ], $target_file ) ) {
                        $file_name = $_FILES[ "file_to_upload" ][ "name" ];
                        $file_title = pathinfo( $file_name, PATHINFO_FILENAME );
                        $descriptions = $_POST[ 'descriptions' ] ?? $file_title;

                        $data = [
                            'title' => $file_title,
                            'file_to_upload' => $file_name,
                            'descriptions' => $descriptions,
                        ];

                        if ( $id ) {
                            $data[ 'id' ] = $id;
                        }

                        $file_id = $this->model->save($data);

                        redirect( 'media/details/' . $file_id );
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                if ( $id && isset( $_POST[ 'descriptions' ] ) ) {
                    $descriptions = $_POST[ 'descriptions' ];

                    $updated = $this->model->save( [
                        'id' => $id,
                        'descriptions' => $descriptions,
                    ] );

                    if ( $updated ) {
                        redirect( 'media/details/' . $id );
                    }
                } else {
                    redirect( 'media' );
                }
            }
        } else {
            redirect('media');
        }
    }


    public function delete() {
    try {
        $ids = $_POST['ids'];
        $deleted = false;

        if (is_array($ids)) {
            foreach ($ids as $id) {
                $deleted = $this->model->delete($id);
            }
        } else {
            $id = $_POST['id'];
            $deleted = $this->model->delete($id);
        }

        if ($deleted) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete file(s)']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}

}
