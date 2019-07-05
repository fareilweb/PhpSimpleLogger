<?php
class PhpSimpleLogger {

    private $log_file;
    private $log_data_about_request;

    /**
     * Constructor of PhpLogger class
     *
     * @param string $log_file_path
     * @param string $log_file_name
     * @param boolean $prepend_date_to_filename
     * @param boolean $log_data_about_request
     */
    public function __construct(
        string $log_file_path = __DIR__ . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR,
        string $log_file_name = 'log.log',
        bool $prepend_date_to_filename = false,
        bool $log_data_about_request = false
    ) {
        if( $prepend_date_to_filename ) {
            $date = (new DateTime())->format("Ymd");
            $this->log_file = $log_file_path . $date . '_' . $log_file_name;
        } else {
            $this->log_file = $log_file_path . $log_file_name;
        }

        $this->log_data_about_request = $log_data_about_request;
    }

    /**
     * Log with info "label"
     *
     * @param string $text
     * @param string $data_to_print_r
     * @return void
     */
    public function info($text, $data_to_print_r = NULL) {
        $this->append_log_to_file($text, $data_to_print_r, "INFO");
    }

    /**
     * Log with warning "label"
     *
     * @param string $text
     * @param string $data_to_print_r
     * @return void
     */
    public function warning($text, $data_to_print_r = NULL) {
        $this->append_log_to_file($text, $data_to_print_r, "WARNING");
    }

    /**
     * Log with error "label"
     *
     * @param string $text
     * @param string $data_to_print_r
     * @return void
     */
    public function error($text, $data_to_print_r = NULL) {
        $this->append_log_to_file($text, $data_to_print_r, "ERROR");
    }



    private function append_log_to_file($text, $data_to_print_r = NULL, $log_label = "INFO") {
        $content = "[".$this->get_timestamp()."] [{$log_label}] - ";
        $content.= $text . PHP_EOL;

        if( $this->log_data_about_request ) {
            $data = array(
                'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
                'HTTP_COOKIE' => $_SERVER['HTTP_COOKIE'],
                'PATH' => $_SERVER['PATH'],
                'SERVER_NAME' => $_SERVER['SERVER_NAME'],
                'SERVER_ADDR' => $_SERVER['SERVER_ADDR'],
                'SERVER_PORT' => $_SERVER['SERVER_PORT'],
                'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
                'REMOTE_PORT' => $_SERVER['REMOTE_PORT'],
                'REQUEST_SCHEME' => $_SERVER['REQUEST_SCHEME'],
                'SCRIPT_FILENAME' => $_SERVER['SCRIPT_FILENAME'],
                'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                'QUERY_STRING' => $_SERVER['QUERY_STRING'],
                'REQUEST_URI' => $_SERVER['REQUEST_URI']
            );
            $content .= print_r($data, true) . PHP_EOL;
        }

        if( !empty($data_to_print_r) ) {
            $content .= print_r($data_to_print_r, true) . PHP_EOL;
        }

        if( $_GET['debug'] ) {
            echo $this->log_file;
        }

        @file_put_contents($this->log_file, $content, FILE_APPEND);

    }

    private function get_timestamp() {
        return (new DateTime())->format("Y-m-d h:i:s");
    }
}