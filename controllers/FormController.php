<?php

class FormController
{
    private $wpdb;
    private $table_name_wintersport;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name_wintersport = $wpdb->prefix . 'wintersport';

        add_action('wp_ajax_submit_survey', [$this, 'submit_survey']);
        add_action('wp_ajax_nopriv_submit_survey', [$this, 'submit_survey']);

        add_action('init', [$this, 'register_shortcodes']);
    }

    public function register_shortcodes()
    {
        add_shortcode('wintersport_quiz', [$this, 'render_survey_shortcode']);
    }

    public function render_survey_shortcode()
    {
        $json_path = plugin_dir_path(dirname(__FILE__)) . 'vragen_antwoorden.json';
        $json_data = file_get_contents($json_path);
        $vragen_antwoorden = json_decode($json_data, true);

        $vragen = array_column($vragen_antwoorden['vragen'], 'vraag');
        $antwoorden = array_column($vragen_antwoorden['vragen'], 'antwoorden');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['action']) && $_POST['action'] == 'restart') {
                $vraag_nummer = 0;
                $antwoorden_sessie = [];
            } else {
                $vraag_nummer = (int)$_POST['vraag_nummer'] + 1;
                $antwoorden_sessie = isset($_POST['antwoorden']) ? json_decode(stripslashes($_POST['antwoorden']), true) : [];

                $antwoord_parts = explode(' ', $_POST['antwoord'], 2);
                $antwoorden_sessie[$vraag_nummer - 1] = [
                    'index' => $antwoord_parts[0],
                    'value' => $antwoord_parts[1] ?? ''
                ];

                if ($vraag_nummer >= count($vragen)) {
                    $aanbevolen_gebieden = $this->get_recommendations($antwoorden_sessie);
                    $this->save_answers($antwoorden_sessie, $aanbevolen_gebieden);

                    ob_start();
                    include plugin_dir_path(__FILE__) . '../views/form_view.php';
                    return ob_get_clean();
                }
            }
        } else {
            $vraag_nummer = 0;
            $antwoorden_sessie = [];
        }

        ob_start();
        include plugin_dir_path(__FILE__) . '../views/form_view.php';
        return ob_get_clean();
    }

    private function get_recommendations($antwoorden)
    {
        $json_path = plugin_dir_path(dirname(__FILE__)) . 'gebieden.json';
        $json_data = file_get_contents($json_path);
        $gebieden = json_decode($json_data, true);

        $beste_match = null;
        $beste_score = PHP_INT_MAX;

        foreach ($gebieden as $gebied) {
            $score = 0;

            $score += isset($gebied['vliegveld']) ? abs(intval($antwoorden[1]['index']) - intval($gebied['vliegveld'])) : PHP_INT_MAX;
            $score += isset($gebied['prijsniveau']) ? abs(intval($antwoorden[10]['index']) - intval($gebied['prijsniveau'])) : PHP_INT_MAX;
            $score += isset($gebied['niveau']) ? abs(intval($antwoorden[4]['index']) - intval($gebied['niveau'])) : PHP_INT_MAX;
            $score += isset($gebied['sneeuwzekerheid']) ? abs(intval($antwoorden[3]['index']) - intval($gebied['sneeuwzekerheid'])) : PHP_INT_MAX;
            $score += isset($gebied['offpiste']) ? abs(intval($antwoorden[5]['index']) - intval($gebied['offpiste'])) : PHP_INT_MAX;
            $score += isset($gebied['sfeer']) ? abs(intval($antwoorden[6]['index']) - intval($gebied['sfeer'])) : PHP_INT_MAX;
            $score += isset($gebied['faciliteiten']) ? abs(intval($antwoorden[7]['index']) - intval($gebied['faciliteiten'])) : PHP_INT_MAX;

            if ($score < $beste_score) {
                $beste_score = $score;
                $beste_match = $gebied;
            }
        }

        return $beste_match ? $beste_match : [];
    }

    private function save_answers($antwoorden)
    {
        $aanbevolen_gebied = $this->get_recommendations($antwoorden);

        $this->wpdb->insert($this->table_name_wintersport, [
            'land' => $antwoorden[0]['index'],
            'vliegveld' => $antwoorden[1]['index'],
            'grootte' => $antwoorden[2]['index'],
            'sneeuwzekerheid' => $antwoorden[3]['index'],
            'kindvriendelijk' => $antwoorden[4]['index'],
            'offpiste' => $antwoorden[5]['index'],
            'apresski' => $antwoorden[6]['index'],
            'activiteiten' => $antwoorden[7]['index'],
            'skimodern' => $antwoorden[8]['index'],
            'metwie' => $antwoorden[9]['index'],
            'budget' => $antwoorden[10]['index'],
            'aanbeveling' => isset($aanbevolen_gebied['gebied']) ? $aanbevolen_gebied['gebied'] : 'Geen aanbeveling'
        ]);

        $aanbevolen_gebied_naam = isset($aanbevolen_gebied['gebied']) ? $aanbevolen_gebied['gebied'] : 'Geen aanbeveling';

        ob_start();
        include plugin_dir_path(__FILE__) . '../views/form_view.php';
        echo ob_get_clean();
        die();
    }
}
