<?php

namespace Application\Controller\Plugin;

use Application\Exception\FormServiceProcessException;
use Laminas\Form\Form;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use Laminas\Mvc\Controller\Plugin\Params;
use Laminas\Mvc\I18n\Translator;
use Laminas\View\Model\JsonModel;
use Application\Exception\FormProcessException;

class JsonWrapper extends AbstractPlugin
{
    public function __construct(
        private Translator $translator
    ) {
    }

    public function wrap($callable): JsonModel
    {
        $response = ['success' => false];
        if (is_callable($callable)) {
            try {
                $returnedData = $callable();

                if (is_string($returnedData)) {
                    $response['message'] = $returnedData;
                } elseif (is_array($returnedData)) {
                    $response = array_merge($response, $returnedData);
                }
                // assume success, unless exceptions are thrown, or success flag is returned
                if (!isset($returnedData['success'])) {
                    $response['success'] = true;
                }
            } catch (FormServiceProcessException $exception) {
                $response['message'] = $exception->getMessage();
                $response['form_errors'] = $exception->getFormErrors();
            } catch (\Exception $x) {
                $message = $x->getMessage();
                $response['message'] = $message !== '' ? $message : get_class($x);
            }
        }

        return new JsonModel($response);
    }

    /**
     * This helper will set data for a form, and the callable gives you a simplification into
     * the post-validation callback block.
     */
    public function wrapForm(Form $form, array $rawData, $callable): JsonModel
    {
        $response = ['success' => false];
        if (is_callable($callable)) {
            try {
                $form->setData($rawData);
                if (!$form->isValid()) {
                    throw new FormProcessException(
                        $form,
                        $this->translator->translate('Sorry! Please check the form for errors.'),
                    );
                }

                $returnedData = $callable($form->getData());

                if (is_string($returnedData)) {
                    $response['message'] = $returnedData;
                } else {
                    if (is_array($returnedData)) {
                        $response = array_merge($response, $returnedData);
                    }
                }

                // assume success, unless exceptions are thrown, or success flag is returned
                if (!isset($returnedData['success'])) {
                    $response['success'] = true;
                }
            } catch (FormProcessException $exception) {
                $response['message'] = $exception->getMessage();
                $response['form_errors'] = $exception->getFieldErrors();
            } catch (\Exception $x) {
                $message = $x->getMessage();
                $response['message'] = $message !== '' ? $message : get_class($x);
            }
        }

        return new JsonModel($response);
    }

    public function wrapWithPost(Params $params, array $required, $callable): JsonModel
    {
        $response = ['success' => false];

        $arguments = [];
        foreach ($required as $postVariable) {
            if ($params->fromPost($postVariable) === null) {
                $response['message'] = "$postVariable is required.";

                return new JsonModel($response);
            }
            $arguments[] = $params->fromPost($postVariable);
        }

        if (is_callable($callable)) {
            try {
                $returnedData = call_user_func_array($callable, $arguments);

                if (is_string($returnedData)) {
                    $response['message'] = $returnedData;
                } elseif (is_array($returnedData)) {
                    $response = array_merge($response, $returnedData);
                }
                // assume success, unless exceptions are thrown, or success flag is returned
                if (!isset($returnedData['success'])) {
                    $response['success'] = true;
                }
            } catch (FormServiceProcessException $exception) {
                $response['message'] = $exception->getMessage();
                $response['form_errors'] = $exception->getFormErrors();
            } catch (\Exception $x) {
                $response['message'] = $x->getMessage();
            }
        }

        return new JsonModel($response);
    }
}
