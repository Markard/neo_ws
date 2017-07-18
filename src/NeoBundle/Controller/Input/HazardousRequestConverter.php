<?php

namespace NeoBundle\Controller\Input;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HazardousRequestConverter implements ParamConverterInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritdoc
     */
    public function apply(Request $httpRequest, ParamConverter $configuration)
    {
        $hazardous = $httpRequest->query->getBoolean('hazardous', false);
        $request = new HazardousRequest($hazardous);

        $httpRequest->attributes->set($configuration->getName(), $request);

        $options = (array)$configuration->getOptions();
        $validatorOptions = $this->getValidatorOptions($options);
        $errors = $this->validator->validate($request, null, $validatorOptions['groups']);
        $httpRequest->attributes->set('validationErrors', $errors);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function getValidatorOptions(array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'groups' => null,
            'traverse' => false,
            'deep' => false,
        ]);

        return $resolver->resolve(isset($options['validator']) ? $options['validator'] : []);
    }

    /**
     * @inheritdoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === HazardousRequest::class;
    }
}
