<?php

require_once __DIR__ . '/client/GitHubClient.php';

$owner = 'EC-CUBE';
$repo = 'ec-cube';

$from = isset($_GET['from']) ? $_GET['from'] : date("Y-m-1 00:00:00");
$to = isset($_GET['to']) ? $_GET['to'] : date("Y-m-1 00:00:00");

$client = new GitHubClient();

$client->setPage();
$client->setPageSize(100);
$data = array(
    'state' => 'all',
);
$issues = $client->request("/repos/EC-CUBE/ec-cube/issues", 'GET', $data, 200, 'GitHubIssue', true);

$summary = '';
foreach ($issues as $issue) {
    $summary .= method_exists($issue->getPullRequest(), 'getHtmlUrl') ? '[P]' : '[I]';
    /* @var $issue GitHubIssue */
    $summary .= "[" . $issue->getNumber() . "]: "
        . $issue->getState()
        . $issue->getTitle()
        . $issue->getUser()->getLogin()
        . $issue->getCreatedAt()
        . "<br />";
}

echo $summary;
