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
		public function statusResponse(StatusService $status): RestResponse {
			$code = $status->status();

			switch ($code) {
				case 201:
					$response = $this->created();
					break;
				case 202:
					$response = $this->accepted();
					break;
				case 204:
					$response = $this->noContent();
					break;
				case 400:
					$response = $this->badRequest();
					break;
				case 401:
					$response = $this->unauthorized();
					break;
				case 403:
					$response = $this->forbidden();
					break;
				case 404:
					$response = $this->notFound();
					break;
				case 405:
					$response = $this->methodNotAllowed();
					break;
				case 408:
					$response = $this->requestTimeout();
					break;
				case 412:
					$response = $this->preconditionFailed();
					break;
				case 415:
					$response = $this->mediaType();
					break;
				case 416:
					$response = $this->rangeNotSatisfiable();
					break;
				case 500:
					$response = $this->internal();
					break;
				case 304:
					return $this->notModified();
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
					$response->withValidation($data);
				else
					$response->withContent(null, $data);
			}

			if (isset($response))
				return $response;
			else
				return $this->internal()->withMessage('Response not generated');
		}
	}