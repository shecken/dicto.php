<?php

namespace Lechimp\Dicto\Report;

/**
 * Shows the number of added or resolved violations
 */
class ViolationRankingReport extends Report {
    /**
     * @inheritdoc
     */
    protected function default_template() {
        return "vio_ranking";
    }

    /**
     * @return  string|null
     */
    protected function source_url() {
        return $this->custom_config_value("source_url", null);
    }

    /**
     * @inheritdoc
     */
    public function generate() {
        $all_runs = $this->queries->all_runs();
        $vio_ranking = array();

        foreach ($all_runs as $cur_run) {
            try {
                $prev_run = $this->queries->run_with_different_commit_before($cur_run);
            } catch(\RuntimeException $e) {
                continue;
            }

            $current = $this->queries->run_info($cur_run);

            if(!array_key_exists($current["commit_author"], $vio_ranking)) {
                $vio_ranking[$current["commit_author"]]["added"] = 0;
                $vio_ranking[$current["commit_author"]]["resolved"] = 0;
            }

            $vio_ranking[$current["commit_author"]]["added"] += $this->queries->count_added_violations($prev_run, $cur_run);
            $vio_ranking[$current["commit_author"]]["resolved"] += $this->queries->count_resolved_violations($prev_run, $cur_run);
        }

        return $vio_ranking;
    }
}