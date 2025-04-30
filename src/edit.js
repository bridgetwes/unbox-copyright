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
import { useId } from 'react';
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

export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();
	const labelId = useId();

	return (
		<div {...blockProps}>
			<label id={labelId} className="unbox-copyright-label">{__("©: [current year] and [site title] will be replaced with the actual values on the frontend. Example: ©[current year] [site title]. All rights reserved.", 'unbox')}</label>
			<RichText
				tagName="p"
				className="unbox-copyright-text"
				onChange={(newInput) => setAttributes({ input: newInput })}
				value={attributes.input}
				placeholder={__("", 'unbox')}
				aria-describedby={labelId}
			/>
		</div>
	);
}
