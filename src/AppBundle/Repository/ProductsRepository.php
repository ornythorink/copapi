<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use AppBundle\Utils\DataStoreIterator;

/**
 * ProductsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductsRepository extends EntityRepository
{

    protected $brandFilter;

    public function findLatestForHome($term, $locale)
    {
        $qb =  $this->createQueryBuilder('p');
        $query =
            $qb->select("p,
             MATCH_AGAINST(p.name,p.description,p.categoryMerchant , :term 'IN  BOOLEAN MODE')
             as Relevance")
            ->where("MATCH_AGAINST (p.name,p.description,p.categoryMerchant, :term2 'IN  BOOLEAN MODE')  > 0.8")
            ->setParameter("term",  $term)
            ->setParameter("term2", $term)
            ->setMaxResults(100)
            ->orderBy('Relevance')->getQuery();

        $set = $query->getResult();

        $data = array();

        $it = new DataStoreIterator($data);

        foreach($set as $s){
            $s[0]->setRelevance($s['Relevance']);
            $s[0]->setOffers($s[0]);
            $it->setPriceFilter($s[0]->getPrice());
            $it->setBrandFilter($this->defineBrandFilter($s[0]->getBrand()));
            $it->append($s[0]);
        }
        return $it;
    }


    public function findRestLatestForHome($term, $locale= "fr")
    {
        $qb =  $this->createQueryBuilder('p');
        $query =
            $qb->select("p,
             MATCH_AGAINST(p.name,p.description,p.categoryMerchant , :term 'IN  BOOLEAN MODE')")
                ->where("MATCH_AGAINST (p.name,p.description,p.categoryMerchant, :term2 'IN  BOOLEAN MODE')  > 0.8")
                ->setParameter("term",  $term)
                ->setParameter("term2", $term)
                ->setMaxResults(100)
                ->getQuery()
                ->orderBy('Relevance')->getQuery();

        $result = $query->getResult();

        return $result;
    }


    public function findForCategory($term, $locale)
    {
        $qb =  $this->createQueryBuilder('p');
        $query =
            $qb->select("p,
             MATCH_AGAINST(p.name,p.description,p.categoryMerchant , :term 'IN  BOOLEAN MODE')
             as Relevance")
                ->where("MATCH_AGAINST (p.name,p.description,p.categoryMerchant, :term2 'IN  BOOLEAN MODE')  > 0.8")
                ->setParameter("term",  $term)
                ->setParameter("term2", $term)
                ->setMaxResults(100)
                ->orderBy('Relevance')->getQuery();

        $set = $query->getResult();

        $data = array();

        $it = new DataStoreIterator($data);

        foreach($set as $s){
            $s[0]->setRelevance($s['Relevance']);
            $s[0]->setOffers($s[0]);
            $it->setPriceFilter($s[0]->getPrice());
            $it->setBrandFilter($this->defineBrandFilter($s[0]->getBrand()));
            $it->append($s[0]);
        }
        return $it;
    }




    public function findRestForCategory($term, $locale= "fr")
    {
        $qb =  $this->createQueryBuilder('p');
        $query =
            $qb->select("p,
             MATCH_AGAINST(p.name,p.description,p.categoryMerchant , :term 'IN  BOOLEAN MODE')")
                ->where("MATCH_AGAINST (p.name,p.description,p.categoryMerchant, :term2 'IN  BOOLEAN MODE')  > 0.8")
                ->setParameter("term",  $term)
                ->setParameter("term2", $term)
                ->setMaxResults(100)
                ->getQuery();

        $result = $query->getResult();

        return $result;
    }


    public function defineBrandFilter($brand){
        if($brand != "" && $brand != null){
            if(isset( $this->brandFilter[strtolower($brand)])){
                $this->brandFilter[strtolower($brand)]['weight'] =
                    $this->brandFilter[strtolower($brand)]['weight'] + 1;
                $this->brandFilter[strtolower($brand)]['name']   = $brand;
            } else {
                $this->brandFilter[strtolower($brand)]['name']   = $brand;
                $this->brandFilter[strtolower($brand)]['weight'] = 1;
            }
        }

        return $this->brandFilter;
    }


    /**
     * Get the paginated list of published articles
     *
     * @param int $page
     * @param int $maxperpage
     * @param string $sortby
     * @return Paginator
     */
    public function getPaginatedProductsToValidate($page=1, $maxperpage=10)
    {
        $q = $this->_em->createQueryBuilder()
            ->select('produits')
            ->from('AppBundle:Products','produits')
            ->where('produits.status = :status ')
            ->setParameter('status' , "Validation" )
        ;
    
        $q->setFirstResult(($page-1) * $maxperpage)
            ->setMaxResults($maxperpage);
 
        return new Paginator($q);
    }

    public function ZnxImportCsv(array $produit, $feedId)
    {
        $repoFeed = $this->_em->getRepository('AppBundle\Entity\FeedCSV');

        $site = $repoFeed->find($feedId);
        $sitename = $site->getSitename();


        $image = "";
        if ($produit['ImageLargeURL'] != "" && $produit['ImageLargeURL'] !== null) {
            $image = $produit['ImageLargeURL'];
        } else if ($produit['ImageMediumURL'] != "" && $produit['ImageMediumURL'] !== null){
            $image = $produit['ImageMediumURL'];
        } else if ($produit['ImageSmallURL'] != "" && $produit['ImageSmallURL'] !== null){
            $image = $produit['ImageSmallURL'];
        }


        $sql  = <<<SQL
                            INSERT IGNORE
                        INTO products
                        (
                            id,
                            name,
                            price,
                            currency,
                            site_id,
                            promo,
                            `status`,
                            brand,
                            image,
                            source_id,
                            program,
                            actif,
                            locale,
                            category_merchant,
                            softdeleted,
                            createdAt,
                            updateAt,
                            description,
                            url,
                            short_url,
                            source_type,
                            logostore
                         ) VALUES (
                            NULL,
                            :name,
                            :price,
                            :currency,
                            :site_id,
                            :promo,
                            :status,
                            :brand,
                            :image,
                            :source_id,
                            :program,
                            :actif,
                            :locale,
                            :category_merchant,
                            :softdeleted,
                             NOW(),
                             NOW(),
                            :description,
                            :url,
                            :short_url,
                            :source_type,
                            :logostore

                         );
SQL;

        $stmt = $this->_em->getConnection()->prepare($sql);
        $stmt->bindValue("name", $produit['ProductName']);
        $stmt->bindValue("price", $produit['ProductPrice']);
        $stmt->bindValue("currency", $produit['CurrencySymbolOfPrice']);
        $stmt->bindValue("site_id", $feedId);
        $stmt->bindValue("promo", $produit['ProductPrice']);
        $stmt->bindValue("status", "Validation");
        $stmt->bindValue("brand", $produit['ProductManufacturerBrand']);
        $stmt->bindValue("image", $image);
        $stmt->bindValue("source_id", 'znx');
        $stmt->bindValue("program", $sitename);
        $stmt->bindValue("actif", 'Y');
        $stmt->bindValue("locale", 'fr');
        $stmt->bindValue("category_merchant", $produit['MerchantProductCategoryPath']);
        $stmt->bindValue("softdeleted", NULL);
        $stmt->bindValue("description", $produit['ProductLongDescription']);
        $stmt->bindValue("url", $produit['ZanoxProductLink']);
        $stmt->bindValue("short_url", md5($produit['ZanoxProductLink']));
        $stmt->bindValue("source_type", 'csv');
        $stmt->bindValue("logostore", NULL);

        $stmt->execute();
    }

    public function TddImportCsv(array $produit, $feedId)
    {

        $repoFeed = $this->_em->getRepository('AppBundle\Entity\FeedCSV');

        $site = $repoFeed->find($feedId);
        $sitename = $site->getSitename();


        $sql  = <<<SQL
                            INSERT IGNORE
                        INTO products
                        (
                            id,
                            name,
                            price,
                            currency,
                            site_id,
                            promo,
                            `status`,
                            brand,
                            image,
                            source_id,
                            program,
                            actif,
                            locale,
                            category_merchant,
                            softdeleted,
                            createdAt,
                            updateAt,
                            description,
                            url,
                            short_url,
                            source_type,
                            logostore
                         ) VALUES (
                            NULL,
                            :name,
                            :price,
                            :currency,
                            :site_id,
                            :promo,
                            :status,
                            :brand,
                            :image,
                            :source_id,
                            :program,
                            :actif,
                            :locale,
                            :category_merchant,
                            :softdeleted,
                             NOW(),
                             NOW(),
                            :description,
                            :url,
                            :short_url,
                            :source_type,
                            :logostore

                         );
SQL;

        $stmt = $this->_em->getConnection()->prepare($sql);
        $stmt->bindValue("name", $produit['name']);
        $stmt->bindValue("price", $produit['price']);
        $stmt->bindValue("currency", $produit['currency']);
        $stmt->bindValue("site_id", $feedId);
        $stmt->bindValue("promo", $produit['price']);
        $stmt->bindValue("status", "Validation");
        $stmt->bindValue("brand", $produit['brand']);
        $stmt->bindValue("image", $produit['imageUrl']);
        $stmt->bindValue("source_id", 'tdd');
        $stmt->bindValue("program", $sitename);
        $stmt->bindValue("actif", 'Y');
        $stmt->bindValue("locale", 'fr');
        $stmt->bindValue("category_merchant", $produit['merchantCategoryName']);
        $stmt->bindValue("softdeleted", NULL);
        $stmt->bindValue("description", $produit['description']);
        $stmt->bindValue("url", $produit['productUrl']);
        $stmt->bindValue("short_url", md5($produit['productUrl']));
        $stmt->bindValue("source_type", 'csv');
        $stmt->bindValue("logostore", NULL);

        $stmt->execute();
    }



}