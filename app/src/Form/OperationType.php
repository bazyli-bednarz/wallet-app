<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
 */

namespace App\Form;

use App\Entity\Category;
use App\Entity\Operation;
use App\Entity\Wallet;
use App\Form\DataTransformer\TagsDataTransformer;
use App\Form\DataTransformer\ValueDataTransformer;
use App\Repository\WalletRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

/**
 * Class OperationType.
 */
class OperationType extends AbstractType
{
    private Security $security;

    private TagsDataTransformer $tagsDataTransformer;

    private ValueDataTransformer $valueDataTransformer;

    /**
     * OperationType constructor.
     *
     * @param TagsDataTransformer  $tagsDataTransformer
     * @param Security             $security
     * @param ValueDataTransformer $valueDataTransformer
     */
    public function __construct(TagsDataTransformer $tagsDataTransformer, Security $security, ValueDataTransformer $valueDataTransformer)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
        $this->security = $security;
        $this->valueDataTransformer = $valueDataTransformer;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'label_name',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );

        $builder->add(
            'value',
            TextType::class,
            [
                'label' => 'label_operation_value',
                'required' => true,
            ]
        );

        $builder->get('value')->addModelTransformer(
            $this->valueDataTransformer
        );

        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                },
                'label' => 'label_category',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );
        $builder->add(
            'wallet',
            EntityType::class,
            [
                'class' => Wallet::class,
                'query_builder' => function (WalletRepository $walletRepository) {
                    return $walletRepository->queryByAuthor($this->security->getUser());
                },

                'choice_label' => function ($wallet) {
                    return $wallet->getName();
                },
                'label' => 'label_wallet',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );

        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label_tags',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );
        $builder->get('tags')->addModelTransformer(
            $this->tagsDataTransformer
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Operation::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'operation';
    }
}
