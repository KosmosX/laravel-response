<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 18/06/19
	 * Time: 17.45
	 */

	namespace Kosmosx\Response\Laravel;

	use Kosmosx\Helpers\Status\StatusService;
	use Kosmosx\Response\Factory\FactoryResponse as Factory;
	use Kosmosx\Response\RestResponse;

	class FactoryResponse extends Factory
	{
		public static function statusResponse(StatusService $status): RestResponse {
			$code = $status->status();

			switch ($code) {
				case 201:
					$response = self::created();
					break;
				case 202:
					$response = self::accepted();
					break;
				case 204:
					$response = self::noContent();
					break;
				case 400:
					$response = self::badRequest();
					break;
				case 401:
					$response = self::unauthorized();
					break;
				case 403:
					$response = self::forbidden();
					break;
				case 404:
					$response = self::notFound();
					break;
				case 405:
					$response = self::methodNotAllowed();
					break;
				case 408:
					$response = self::requestTimeout();
					break;
				case 412:
					$response = self::preconditionFailed();
					break;
				case 415:
					$response = self::mediaType();
					break;
				case 416:
					$response = self::rangeNotSatisfiable();
					break;
				case 500:
					$response = self::internal();
					break;
				case 304:
					return self::notModified();
					break;
				default:
					$response = new RestResponse(null, $code ?: 200);
			}

			if ($message = $status->message()) {
				if ($status->isFail())
					$response->withError($message, false, 'message');
				else
					$response->withMessage($message);
			}

			if ($data = $status->data()) {
				if ($status->isFail())
					$response->withError($data);
				else
					$response->withContent(null, $data);
			}

			if($validate = $status->validate())
				$response->withValidation($validate);

			if (isset($response))
				return $response;

			return self::throwException('Response not generated');
		}
	}