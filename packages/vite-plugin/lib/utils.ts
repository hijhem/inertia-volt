const phpCodeBlockRegex = /<\?php(\n|\s|\t)[\s\S]*?\?>[\n\s\t]+/g;

export function stripPhpTags(code: string) {
	return code.replace(phpCodeBlockRegex, '');
}
