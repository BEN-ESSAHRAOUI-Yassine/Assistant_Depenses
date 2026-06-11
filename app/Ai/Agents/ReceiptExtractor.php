<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;


class ReceiptExtractor implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): string
    {
        return <<<PROMPT
        You extract expenses from Moroccan supplier receipts.

        The receipt may contain:
        - French
        - Darija
        - abbreviations
        - spelling mistakes

        Extract only actual purchased products.

        If the text is not a receipt,
        return an empty articles array.

        Categorize each article into one of:

        - alimentaire
        - boissons
        - hygiene
        - entretien
        - autre
        PROMPT;
    }

     /**
     * Get the agent's structured output schema definition.
     */

    public function schema(JsonSchema $schema): array
    {
        return [
            'articles' => $schema->array()->items(
                $schema->object(
                    fn (JsonSchema $schema) => [
                        'libelle' => $schema
                            ->string()
                            ->required(),

                        'quantite' => $schema
                            ->integer()
                            ->required(),

                        'prix_unitaire' => $schema
                            ->number()
                            ->required(),

                        'categorie' => $schema
                            ->string()
                            ->enum([
                                'alimentaire',
                                'boissons',
                                'hygiene',
                                'entretien',
                                'autre',
                            ])
                            ->required(),
                    ]
                )
            )->required(),
            'total_estime' => $schema
                ->number()
                ->required(),

            'currency' => $schema
                ->string()
                ->required(),
        ];
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }

   

}