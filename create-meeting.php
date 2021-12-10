<?php
require_once 'config.php';

function create_meeting()
{
    // $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);

    $db = new DB();
    $arr_token = $db->get_access_token();
    $accessToken = $arr_token->access_token;
    print_r($accessToken);
    die();

    try {
        /////zoom.30a-1@kips.edu.pk
        $user_id = "LDSVkj3HQUyHARCka39umw";
        /*$url = 'https://api.zoom.us/v2/users/' . $user_id . '/meetings';
        $data = [
            "agenda" => "",
            "duration" => "30",
            "password" => "",
            "recurrence" => [
                "end_date_time" => "2020-07-31T20:30:00Z",
                "end_times" => "",
                "monthly_day" => "",
                "monthly_week" => "",
                "monthly_week_day" => "",
                "repeat_interval" => "2",
                "type" => "1",
                "weekly_days" => ""
            ],
            "schedule_for" => "",
            "settings" => [
                "alternative_hosts" => "",
                "approval_type" => "1",
                "audio" => "both",
                "auto_recording" => "cloud",
                "cn_meeting" => "false",
                "enforce_login" => "false",
                "enforce_login_domains" => "false",
                "global_dial_in_countries" => [
                    ""
                ],
                "host_video" => "true",
                "in_meeting" => "false",
                "join_before_host" => "true",
                "mute_upon_entry" => "true",
                "participant_video" => "false",
                "registrants_email_notification" => "false",
                "registration_type" => "2",
                "use_pmi" => "false",
                "watermark" => "false"
            ],
            "start_time" => "2020-07-26T20:30:00Z",
            "timezone" => "",
            "topic" => "TEST Meetings IT Department 25",
            "type" => "2"
        ];*/
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
        $response = $client->request('POST', '/v2/users/' . $user_id . '/meetings', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ],
            'json' => [
                "agenda" => "",
                "duration" => "30",
                "password" => "",
                "recurrence" => [
                    "end_date_time" => "2020-07-31T20:30:00Z",
                    "end_times" => "",
                    "monthly_day" => "",
                    "monthly_week" => "",
                    "monthly_week_day" => "",
                    "repeat_interval" => "2",
                    "type" => "1",
                    "weekly_days" => ""
                ],
                "schedule_for" => "",
                "settings" => [
                    "alternative_hosts" => "",
                    "approval_type" => "1",
                    "audio" => "both",
                    "auto_recording" => "cloud",
                    "cn_meeting" => "false",
                    "enforce_login" => "false",
                    "enforce_login_domains" => "false",
                    "global_dial_in_countries" => [
                        ""
                    ],
                    "host_video" => "true",
                    "in_meeting" => "false",
                    "join_before_host" => "true",
                    "mute_upon_entry" => "true",
                    "participant_video" => "false",
                    "registrants_email_notification" => "false",
                    "registration_type" => "2",
                    "use_pmi" => "false",
                    "watermark" => "false"
                ],
                "start_time" => "2020-07-26T20:30:00Z",
                "timezone" => "",
                "topic" => "TEST Meetings IT Department 25",
                "type" => "2"
            ],
        ]);
        $data = json_decode($response->getBody());
        print_r($data);
    } catch (Exception $e) {
        if (401 == $e->getCode()) {
            $refresh_token = $db->get_refersh_token();

            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic " . base64_encode(CLIENT_ID . ':' . CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "refresh_token",
                    "refresh_token" => $refresh_token
                ],
            ]);
            $token = json_decode($response->getBody()->getContents(), true);
            $db->update_access_token(json_encode($token));
            echo "Access token inserted successfully.";

            create_meeting();
        } else {
            echo $e->getMessage();
        }
    }
}

create_meeting();
