import * as SvgIcons from '../../../icons';
export const getIconComponent = (option) => {
	const iconMap = {
		DOS: SvgIcons.Check,
		DONTS: SvgIcons.Cross,
	};
	// Fallback to a default icon if the option is invalid
	return iconMap[option?.toUpperCase()] || (() => <span>No Icon</span>);
};
