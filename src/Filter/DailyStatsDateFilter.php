<?php


namespace App\Filter;


use ApiPlatform\Core\Serializer\Filter\FilterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DailyStatsDateFilter implements FilterInterface
{
    public const  FROM_FILTER_CONTEXT = 'dailystats_from';

    private $throwOnInvalid;

    public function __construct(bool $throwOnInvalid = false)
    {

        $this->throwOnInvalid = $throwOnInvalid;
    }
    public function apply(Request $request, bool $normalization, array $attributes, array &$context)
    {
        $from = $request->query->get('from');
        if(!$from) {
            return;
        }
        $fromDate = \DateTimeImmutable::createFromFormat('Y-m-d', $from);
        if (!$fromDate && $this->throwOnInvalid) {
            throw new BadRequestHttpException('Invalid "from" date format hhh');
        }
        if($fromDate) {
            $fromDate->setTime(0,0,0);
            $context[self::FROM_FILTER_CONTEXT] = $fromDate;
        }
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'from' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
                'openapi' => [
                    'description' => 'From date e.g. 2020-09-01',
                ],
            ]
        ];
    }
}
