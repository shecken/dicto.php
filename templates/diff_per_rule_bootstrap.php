<?php

function template_diff_per_rule_bootstrap(array $report) {
    $total = $report["violations"]["total"];
    $resolved = $report["violations"]["resolved"];
    $added = $report["violations"]["added"];
    $diff = $resolved - $added;
    if ($resolved == 0 && $added == 0) {
        $msg = '<p>Nothing new...</p>';
    }
    else if ($diff == 0) {
        $msg = '<p>You added and removed violations, but no change in total. Maybe you refactored some code?"</p>';
    }
    else if ($diff > 0 && $added == 0) {
        $msg = '<p class="text-success">You resolved some violations. Great Success!</p>';
    }
    else if ($diff > 0) {
        $msg = '<p class="text-success">You resolved more violations than you added. Nice!</p>';
    }
    else if ($diff < 0 && $resolved != 0) {
        $msg = '<p class="text-danger">You added more violations than you resolved. Don\'t give up!</p>';
    }
    else {
        $msg = '<p class="text-danger">You added some violations. Please take care of the code!</p>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link 
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-2.2.4.min.js"
        crossorigin="anonymous">
    </script> 
    <script
        src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous">
    </script> 
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1> DICTO
                <a href="https://github.com/lechimp-p/dicto.php">
                    <svg
                        xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                        xmlns:svg="http://www.w3.org/2000/svg"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 48 48"
                        width="24px"
                        height="24px"
                        version="1.1">
                        <g>
                            <path
                                d="m 23.999323,-0.00214894 c -13.243142,0 -23.9831342,11.02089394 -23.9831342,24.61680394 0,10.874311 6.8718866,20.101457 16.4030042,23.35801 1.200039,0.225163 1.637354,-0.534951 1.637354,-1.187773 0,-0.584819 -0.0206,-2.132247 -0.03239,-4.185914 C 11.352518,44.08596 9.9448638,39.298602 9.9448638,39.298602 8.8537843,36.454598 7.2812164,35.697508 7.2812164,35.697508 c -2.1777417,-1.526273 0.1649134,-1.49605 0.1649134,-1.49605 2.4074427,0.173784 3.6737422,2.537239 3.6737422,2.537239 2.139459,3.761279 5.614421,2.674754 6.980848,2.044599 0.217921,-1.58974 0.837818,-2.674753 1.522504,-3.289795 -5.325821,-0.6226 -10.9255175,-2.733691 -10.9255175,-12.166353 0,-2.688355 0.9350006,-4.884072 2.4692845,-6.605282 -0.247371,-0.622599 -1.070464,-3.125081 0.235591,-6.514615 0,0 2.012829,-0.6618879 6.595068,2.522128 1.912702,-0.545529 3.965286,-0.817539 6.004619,-0.828117 2.037859,0.01062 4.088969,0.282588 6.004617,0.828117 4.579295,-3.1840159 6.589179,-2.522128 6.589179,-2.522128 1.309,3.389534 0.485904,5.892016 0.240007,6.514615 1.537229,1.72121 2.464868,3.916927 2.464868,6.605282 0,9.456841 -5.608531,11.53771 -10.950551,12.146708 0.859905,0.760114 1.627048,2.262208 1.627048,4.559172 0,3.289796 -0.02945,5.944904 -0.02945,6.751864 0,0.658866 0.432898,1.425025 1.649134,1.18475 9.523755,-3.262596 16.389752,-12.482185 16.389752,-23.354987 0,-13.59591 -10.739992,-24.61680394 -23.987552,-24.61680394"
                                style="fill:#1b1817;fill-opacity:1;fill-rule:evenodd;stroke:none" />
                        </g>
                    </svg>
                </a><br />
                <small>automated architectural tests</small>
            </h1>
        </div>
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        Report with Emphasis on the Diff
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9">
                                <dl class="dl-horizontal">
                                    <dt>commit</dt>
                                    <dd><?= $report["current"]["commit_hash"] ?></dd>
                                    <dt>compared to</dt>
                                    <dd><?= $report["previous"]["commit_hash"] ?></dd>
                                </dl>
                                <div class="jumbotron">
                                    <?=$msg?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Violations</h4>
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <strong>total</strong>
                                                <span class="badge"><?=$total?></span>
                                            </li>
                                            <li class="list-group-item <?=$resolved>0?"list-group-item-success":""?>">
                                                resolved
                                                <span class="badge"><?=$resolved?></span>
                                            </li>
                                            <li class="list-group-item <?=$added>0?"list-group-item-danger":""?>">
                                                added 
                                                <span class="badge"><?=$added?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="panel-group"
            id="rules-accordion"
            role="tablist"
            aria-multiselectable="true">
<?php   $i = 0;
        foreach ($report["rules"] as $rule) {
            $i++;
            $total = $rule["violations"]["total"];
            $resolved = $rule["violations"]["resolved"];
            $added = $rule["violations"]["added"];
            $diff = $resolved - $added;
            if ($diff == 0) {
                $class = "default";
            }
            else if ($diff < 0) {
                $class = "danger";
            }
            else {
                $class = "success";
            }
?>
            <div class="panel panel-<?=$class?>">
                <div class="panel-heading" role="tab" id="rule_<?=$i?>_heading">
                    <h4 class="panel-title">
                        <a
                            role="<?=$i==1?"button":"collapsed"?>"
                            data-toggle="collapse"
                            data-parent="#rules-accordion"
                            href="#rule_<?=$i?>"
                            aria-expanded="<?=$i==1?"true":"false"?>"
                            aria-controls"#rule_<?=$i?>">
                            <?=htmlentities(wordwrap($rule["rule"], 80, " ", true))?> 
                        </a>
                    </h4>
                </div>
                <div
                    id="rule_<?=$i?>"
                    class="panel-collapse collapse <?=$i==1?"in":""?>"
                    role="tabpanel"
                    aria-labelledby="rule_<?=$i?>_heading">
                    <div class="panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="well well-sm">
                                        <?= htmlentities(str_replace("\n", " ", $rule["explanation"])) ?> 
                                    </div>
                                    <ul class="list-group">
<?php       foreach ($rule["violations"]["list"] as $v) {
                if ($v["introduced_in"] == $report["run_id"]) {
                    $cl = "list-group-item-danger";
                }
                else {
                    $cl = "";
                }
?>
                                        <li class="list-group-item <?=$cl?>">
                                            <?=$v["file"]?> (l. <?=$v["line_no"]?>)
<?php           if ($v["url"] !== null) { ?>
                                            <a href="<?=$v["url"]?>" target="_blank">
                                                <span
                                                    class="glyphicon glyphicon-zoom-in"
                                                    aria-hidden="true">
                                                </span>
                                            </a>
<?php           } ?>
                                        </li>
<?php       } ?>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Violations</h4>
                                        </div>
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <strong>total</strong>
                                                    <span class="badge"><?=$total?></span>
                                                </li>
                                                <li class="list-group-item <?=$resolved>0?"list-group-item-success":""?>">
                                                    resolved
                                                    <span class="badge"><?=$resolved?></span>
                                                </li>
                                                <li class="list-group-item <?=$added>0?"list-group-item-danger":""?>">
                                                    added 
                                                    <span class="badge"><?=$added?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php } ?>
        </div>
    </div>
</body>
</html>
<?php
}
