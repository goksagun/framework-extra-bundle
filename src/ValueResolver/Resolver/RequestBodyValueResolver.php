<?php

declare(strict_types=1);

namespace Goksagun\FrameworkExtraBundle\ValueResolver\Resolver;

use Goksagun\FrameworkExtraBundle\Config\Scope;
use Goksagun\FrameworkExtraBundle\ValueResolver\Annotation\RequestBody;
use Goksagun\FrameworkExtraBundle\ValueResolver\Fetcher\ArgumentFetcherFactory;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class RequestBodyValueResolver implements ValueResolverInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ([] === $attrs = $argument->getAttributes(RequestBody::class)) {
            return [];
        }

        $type = $argument->getType();

        $this->logger->debug("The argument type: '" . $type . "'");

        /** @var RequestBody $attr */
        $attr = $attrs[0];

        if (null !== $scope = $attr->getScope()) {
            yield $this->getRequestData($request, $scope, $type);

            return [];
        }

        $format = $request->getContentTypeFormat();

        $this->logger->debug("The request format: '" . $format . "'");

        yield $this->getData($request, $type, $format);
    }

    private function getRequestData(Request $request, Scope $scope, string $type)
    {
        $normalizer = new ObjectNormalizer();

        $data = $normalizer->denormalize(ArgumentFetcherFactory::create($request, $scope)->fetchAll(), $type, 'array');

        $this->logger->debug("Denormalized data: {0}", [$data]);

        return $data;
    }

    private function getData(Request $request, ?string $type, ?string $format): mixed
    {
        $content = $request->getContent();

        switch ($type) {
            case 'string':
                $data = $content;

                $this->logger->debug("Raw data: {0}", [json_encode(json_decode($content))]);
                break;
            case 'array':
                $data = json_decode($content, true);

                $this->logger->debug("Denormalized data: {0}", [$data]);
                break;
            default:
                $data = $this->serializer->deserialize($content, $type, $format);

                $this->logger->debug("Deserialized data: {0}", [$data]);
                break;
        }
        
        return $data;
    }
}