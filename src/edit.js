/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { useLayoutEffect } from '@wordpress/element';
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

const DEFAULT_COPYRIGHT = __(
	'©[current year] [site title]. All rights reserved.',
	'unbox'
);

/**
 * RichText does not call onChange until the text changes. Keep the fallback
 * in the attribute so an unedited default is what gets saved and rendered.
 *
 * @param {string} value Stored copyright line.
 * @return {string} Stored value, or the default when that value is empty.
 */
function copyrightValue( value ) {
	const text = ( value || '' )
		.replace( /<br\s*\/?>/gi, '' )
		.replace( /&nbsp;/gi, '' )
		.replace( /<[^>]*>/g, '' )
		.trim();

	return text ? value : DEFAULT_COPYRIGHT;
}

export default function Edit({ attributes, setAttributes }) {
	const input = copyrightValue( attributes.input );

	useLayoutEffect( () => {
		if ( attributes.input !== input ) {
			setAttributes( { input } );
		}
	}, [ attributes.input, input, setAttributes ] );

	return (
		<>
			<InspectorControls>
				<PanelBody 
					title={__('Copyright Text', 'unbox')} 
					initialOpen={true}
				>
					<p>{__('[current year] [site title] [tag line] will be replaced with the actual values on the frontend.', 'unbox')}</p>
					<p>{__('Example: ©[current year] [site title] [tag line]. All rights reserved.', 'unbox')}</p>
				</PanelBody>
			</InspectorControls>
			<RichText
				{...useBlockProps()}
				tagName="p"
				onChange={ ( newInput ) =>
					setAttributes( { input: copyrightValue( newInput ) } )
				}
				value={input}
				placeholder={__("Example: ©[current year] [site title] [tag line]. All rights reserved.", 'unbox')}
			/>
		</>
	);
}
