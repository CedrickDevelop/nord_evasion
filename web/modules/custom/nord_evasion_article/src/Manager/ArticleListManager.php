<?php

namespace Drupal\nord_evasion_article\Manager;

use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Http\RequestStack;
use Drupal\nord_evasion_article\Entity\ArticleListNodeInterface;
use Drupal\nord_evasion_article\Filters\FromArticleListFormFilters;
use Drupal\nord_evasion_article\Form\ArticleListFilterForm;
use Drupal\nord_evasion_article\Form\ArticleListFormDTO;
use Drupal\nord_evasion_article\Gateway\ArticleListGatewayInterface;
use Drupal\nord_evasion_global\Manager\ThematicsManager;

class ArticleListManager {

  const FILTER_FORM_PREPROCESS_KEY = 'filter_form';

  const ARTICLES_LIST_PREPROCESS_KEY = 'articles_list';

  const RESULTS_TITLE_PREPROCESS_KEY = 'results_title';

  public function __construct(
    protected readonly ArticleListGatewayInterface $articleListGateway,
    protected readonly ArticleManager $articleManager,
    protected readonly ArticleListResultsTitleManager $articleListResultsTitleManager,
    protected readonly ThematicsManager $thematicsManager,
    protected readonly FormBuilderInterface $formBuilder,
    protected readonly RequestStack $requestStack
  ) {
  }

  public function getArticleListNode(): ArticleListNodeInterface {
    return $this->articleListGateway->getLastEditedArticleList();
  }

  public function addArticleListVariablesToPreprocessNode(array $variables): array {
    if (!$this->isNodeOfCurrentBundle($variables)) {
      return $variables;
    }

    $articleFilterDTO = $this->getArticleListFormDTOFiltersFromRequest();
    $resultsNumber = $this->articleManager->getFilteredArticlesTotalCount($articleFilterDTO);

    $variables[self::FILTER_FORM_PREPROCESS_KEY] = $this->getArticleListFilterForm();
    $variables[self::RESULTS_TITLE_PREPROCESS_KEY] = $this->articleListResultsTitleManager->getResultsTitle($articleFilterDTO, $resultsNumber);
    $variables[self::ARTICLES_LIST_PREPROCESS_KEY] = $this->getFilteredArticleList();
    return $variables;
  }

  protected function isNodeOfCurrentBundle(array $variables): bool {
    /** @var \Drupal\node\NodeInterface $currentNode */
    $currentNode = $variables['node'];
    return $currentNode instanceof ArticleListNodeInterface;
  }

  protected function buildFormDTO(): ArticleListFormDTO {
    return new ArticleListFormDTO($this->requestStack->getCurrentRequest()->query->all());
  }

  protected function getArticleListFilterForm(): array {
    $articleListFilterDTO = $this->buildFormDTO();
    return $this->formBuilder->getForm(ArticleListFilterForm::class, $articleListFilterDTO);
  }

  protected function getArticleListFormDTOFiltersFromRequest(): FromArticleListFormFilters {
    $dto = $this->buildFormDTO();
    return new FromArticleListFormFilters($dto);
  }

  protected function getFilteredArticleList() {
    $filtersObjectValue = $this->getArticleListFormDTOFiltersFromRequest();
    return $this->articleManager->getRenderedArticlesForArticleList($filtersObjectValue);
  }

}
