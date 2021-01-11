export interface ApiResult {
  kind: string;
  totalItems: number;
  items: ApiBook[];
}

export interface ApiBook {
  kind: string;
  id: string;
  etag: string;
  selfLink: string;
  volumeInfo: VolumeInfo;
  saleInfo: { country: string; salability: string; isEbook: boolean };
  accessInfo: AccessInfo;
  searchInfo: { textSnippet: string };
}

export interface AccessInfo {
  country: string;
  viewability: string;
  embeddable: boolean;
  publicDomain: boolean;
  textToSpeechPermission: string;
  epub: { isAvailable: boolean };
  pdf: { isAvailable: boolean };
  webReaderLink: string;
  accessViewStatus: string;
  quoteSharingAllowed: boolean;
}

export interface VolumeInfo {
  title: string;
  authors: string[];
  publisher: string;
  publishedDate: string;
  description: string;
  industryIdentifiers: IndustryIdentifier;
  readingModes: { text: boolean; image: boolean };
  pageCount: number;
  printType: string;
  categories: string[];
  averageRating?: number;
  ratingsCount: number;
  maturityRating: string;
  contentVersion: string;
  panelizationSummary: { containsEpubBubbles: boolean; containsImageBubbles: boolean };
  imageLinks: { smallThumbnail: string; thumbnail: string };
  language: string;
  previewLink: string;
  infoLink: string;
  canonicalVolumeLink: string;
}

export interface IndustryIdentifier {
  type: string;
  identifier: string;
}

export interface Book {
  book_id: string;
  rating: number;
  pageCount: number;
  image: string;
  title: string;
  order: number;
}
