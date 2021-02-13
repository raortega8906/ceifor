<?php

class Gmail
{

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function readLabels()
    {
        // Get the API client and construct the service object.
        $service = new Google_Service_Gmail($this->client);

        // Print the labels in the user's account.
        $user = 'me';
        $results = $service->users_labels->listUsersLabels($user);

        if (count($results->getLabels()) == 0) {
            print "No labels found.\n";
        } else {
            print "Labels:\n";
            foreach ($results->getLabels() as $label) {
                printf("- %s\n", $label->getName());
            }
        }
        // [END gmail_quickstart]
    }
}
