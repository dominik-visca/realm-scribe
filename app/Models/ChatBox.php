<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    public static function availableModels()
    {
        return [
            "gpt-3.5-turbo" => [
                "name" => "gpt-3.5-turbo",
                "label" => "GPT-3.5 Turbo",
                "maxTokens" => 4096,
                "description" => "Most capable GPT-3.5 model and optimized for chat at 1/10th the cost of text-davinci-003. Will be updated with OpenAI's latest model iteration."
            ],
            "gpt-3.5-tubo-0301" => [
                "name" => "gpt-3.5-tubo-0301",
                "label" => "GPT-3.5 Turbo (1. März)",
                "maxTokens" => 4096,
                "description" => "Snapshot of gpt-3.5-turbo from March 1st 2023. Unlike gpt-3.5-turbo, this model will not receive updates, and will be deprecated 3 months after a new version is released."
            ],
            "text-davinci-003" => [
                "name" => "text-davinci-003",
                "label" => "text-davinci-003",
                "maxTokens" => 4097,
                "description" => "Can do any language task with better quality, longer output, and consistent instruction-following than the curie, babbage, or ada models. Also supports inserting completions within text."
            ],
            "text-davinci-002" => [
                "name" => "text-davinci-002",
                "label" => "text-davinci-002",
                "maxTokens" => 4097,
                "description" => "Similar capabilities to text-davinci-003 but trained with supervised fine-tuning instead of reinforcement learning."
            ],
            "code-davinci-002" => [
                "name" => "code-davinci-002",
                "label" => "code-davinci-002",
                "maxTokens" => 8001,
                "description" => "Optimized for code-completion tasks."
            ],
        ];
    }

    public static function availableRoles()
    {
        $client = new Client();
        $response = $client->get('https://raw.githubusercontent.com/f/awesome-chatgpt-prompts/main/prompts.csv');
        $records = [];
        $headers = null;
        $csvString = $response->getBody();
        // Remove the first line and last line
        $csvString = substr($csvString, strpos($csvString, "\n") + 1);
        $csvString = substr($csvString, 0, strrpos($csvString, "\n"));
        $prompts = [];

        foreach (explode("\n", $csvString) as $line) {
            $values = str_getcsv($line);

            $promptName = trim($values[0], '"');
            $promptDescription = trim($values[1], '"');

            $prompts[$promptName] = $promptDescription;
        }

        return $prompts;
    }
}