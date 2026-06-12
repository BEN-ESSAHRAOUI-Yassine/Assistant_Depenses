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

class ReceiptExtractor implements Agent, Conversational, HasStructuredOutput, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): string
    {
        return <<<'PROMPT'
        You are an intelligent receipt and invoice data extraction assistant.

        Extract structured data from the receipt text below. The receipt can be in French, English, Spanish, Italian, Arabic, Darija, or mixed.

        Return ONLY valid JSON with this exact structure. Do NOT include markdown, code fences, or any text outside the JSON object.

        {
        "merchant": "Store name or null",
        "merchant_confidence": 0-100,
        "date": "YYYY-MM-DD or null",
        "date_confidence": 0-100,
        "time": "HH:MM or null",
        "time_confidence": 0-100,
        "total_ttc": 0.00 or null,
        "total_ttc_confidence": 0-100,
        "total_ht": 0.00 or null,
        "total_ht_confidence": 0-100,
        "tva": {
            "20.0": 0.00,
            "10.0": 0.00,
            "5.5": 0.00,
            "2.1": 0.00
        },
        "tva_confidence": 0-100,
        "payment_method": "CB" or "Especes" or "Virement" or "Cheque" or "American Express" or "Mastercard" or "Visa" or null,
        "payment_method_detail": "CB *1234" or null,
        "payment_method_confidence": 0-100,
        "currency": "EUR" or "MAD" or "USD" or "GBP" or "CHF" or other,
        "currency_confidence": 0-100,
        "category": "Restaurant" or "Transport" or "Alimentaire" or "Fournitures" or "Hotel" or "Sante" or "Divertissement" or "Carburant" or "Logiciels" or "Voyage" or "Autre",
        "category_confidence": 0-100,
        "receipt_number": "invoice number or null",
        "receipt_number_confidence": 0-100,
        "address": "store address or null",
        "address_confidence": 0-100,
        "notes": null or string,
        "line_items": [
            {
            "label": "item name",
            "quantity": 1,
            "unit_price": 0.00,
            "total": 0.00,
            "category": "item category or null",
            "confidence": 0-100
            }
        ],
        "line_items_confidence": 0-100
        }

        RULES:
        - Confidence 90-100 = certain (GREEN). 70-89 = fairly sure (ORANGE). Below 70 = unsure (RED).
        - If unsure, set confidence < 70 and use null. NEVER invent or guess data you cannot see.
        - unit_price = line total / quantity. Round to 2 decimals.
        - Detect currency from symbols ($, MAD, DH, etc.).
        - Detect payment method from clues like "CB", "carte", "cash", "especes", "visa", "mastercard", "amex".
        - Auto-categorize: Uber/taxi/bus -> Transport, Restaurant/boulangerie -> Restaurant, grocery -> Alimentaire, pharmacie -> Sante, etc.
        - total_ttc = grand total including all taxes.
        - total_ht = subtotal before taxes (calculate from line totals if not explicit).
        - If multiple TVA rates exist, list each rate with its amount.
        - ALL numeric values MUST be actual computed numbers, NEVER formulas or expressions.
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
