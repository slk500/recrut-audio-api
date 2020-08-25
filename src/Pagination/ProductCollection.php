<?php

declare(strict_types=1);

namespace App\Pagination;


use App\Entity\Product;
use Doctrine\Common\Collections\Collection;
use Knp\Component\Pager\PaginatorInterface;

final class ProductCollection
{
    private int $maxPerPage = 3;

    private PaginatorInterface $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @param Collection&Product[] $products
     */
    public function toArray(Collection $products, int $page = 1): array
    {
        $pagination = $this->paginator->paginate(
            $products,
            $page,
            $this->maxPerPage
        );

        return [
            'products' => $pagination,
            'pagination' =>
                [
                    'count' =>
                        [
                            'all' => $pagination->getTotalItemCount(),
                            'current' => $pagination->getCurrentPageNumber(),
                            'maxPerPage' => $pagination->getItemNumberPerPage()
                        ]
                ]
        ];
    }
}